<?php

namespace App\Http\Controllers\GeneralControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentGateway\Braintree;
use App\Http\Controllers\PaymentGateway\Paypal;
use App\Http\Controllers\PaymentGateway\Stripe;
use App\Http\Requests\General\WalletPaymentRequest;
use App\Http\Requests\General\WalletRequest;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\General\WalletResource;
use App\Http\Resources\General\WalletTransactionResource;
use App\Http\Resources\Web\PaymentMethodsResource;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\PaymentMethod;
use App\Models\CMSModels\Wallet;
use App\Models\CMSModels\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public $guard;
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $this->middleware('auth:customer-api');
            $this->guard = 'customer';
        } elseif (auth('rider-api')->check() && auth('rider-api')->user()->tokenCan('rider')) {
            $this->middleware('auth:rider-api');
            $this->guard = 'rider';
        } elseif (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
            $this->middleware('auth:vendor-api');
            $this->guard = 'vendor';
        } elseif (auth('admin-api')->check() && auth('admin-api')->user()->tokenCan('admin')) {
            $this->middleware('auth:admin-api');
            $this->guard = 'admin';
        } else {
        }
    }

    /********* Getter For Pagination, Searching And Sorting  ***********/




    public function depositAmount(WalletPaymentRequest $request)
    {
        $data = $request->all();
        $data['shipping_address'] = generateCustomBodyForPayment();
        $data['total'] = $request->balance;
        $data['payment_type'] = $request->payment_type;
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $customer = auth('customer-api')->user();
        }
        $payment_method_settings = new PaymentMethodsResource(PaymentMethod::withAll()->where('code', $request->payment_method_code)->first());
        $customer = new CustomersResource(Customer::withAll()->find($customer->id));

        if ($payment_method_settings) {
            if ($customer) {
                if ($payment_method_settings->code == 'stripe') {
                    $gateway = new Stripe();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $res = $gateway->executePayment($data, $customer);
                    if ($res['captured'] == true && $res['success'] == true) {
                        $res = $this->depositAfterPaymentVerification($request->balance);
                        return response()->json($res);
                    } else if ($res['success'] == true && $res['captured'] == false) {
                        return response()->json($res);
                    } else {
                        return response()->json($res);
                    }
                } else if ($payment_method_settings->code == 'braintree') {

                    $gateway = new Braintree();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $res = $gateway->executePayment($data, $customer);
                    if ($res['captured'] == true) {
                        $res = $this->depositAfterPaymentVerification($request->balance);
                        return response()->json($res);
                    } else {
                        return response()->json($res);
                    }
                }
            } else {
                return response("No Such Customer Exists", 404);
            }
        } else {
            return response("No Such Payment Method Exists", 404);
        }
    }

    public function withdrawAmount(WalletRequest $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_type', $this->guard)->where('reference_table_id', $user->id)->with('transactions')->first();

        if ($wallet) {
            $opening_balance = $wallet->balance;
            if ($wallet->balance == 0 || $wallet->balance < $request->balance) {
                $response = generateResponse($wallet, false, 'InSufficient Amount ', [], 'object');
                return response($response);
            } else {
                $opening_balance = 0;
                $balance = $wallet->balance - $request->balance;
                $wallet->update([
                    'balance' => $balance,
                ]);
            }
        }
        // get wallet balance

        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['transaction_type'] = 'withdraw';
        $wallet_data['cash_in'] = null;
        $wallet_data['cash_out'] = $request->balance;
        $wallet_data['description'] = 'Withdraw from your wallet';
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount withdraw Successfully', [], 'object');
        return response($response);
    }

    public function RefundAmount(WalletRequest $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_type', $this->guard)->where('reference_table_id', $user->id)->with('transactions')->first();

        if ($wallet) {
            $opening_balance = $wallet->balance;
            $balance = $wallet->balance + $request->balance;
            $wallet->update([
                'balance' => $balance,
            ]);
        } else {
            $response = generateResponse('', false, 'Wallet does not Exist', [], 'object');
            return response($response);
        }
        // get a wallet balance
        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['transaction_type'] = 'refund';
        $wallet_data['cash_in'] = $request->balance;
        $wallet_data['cash_out'] = null;
        $wallet_data['description'] = 'Refunded to your wallet';
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount Refund Successfully', [], 'object');
        return response($response);
    }

    public function depositAfterPaymentVerification($transaction_amount)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_type', $this->guard)->where('reference_table_id', $user->id)->with('transactions')->first();

        if ($wallet) {
            $opening_balance = $wallet->balance;
            $balance = $wallet->balance + $transaction_amount;
            $wallet->update([
                'balance' => $balance,
            ]);
        } else {
            $opening_balance = 0;
            $balance = $transaction_amount;
            $data['balance'] = $transaction_amount;
            $data['user_type'] = $this->guard;
            $data['reference_table_id'] = $user->id;
            $wallet = Wallet::create($data);
            $wallet = Wallet::where('user_type', $this->guard)->where('reference_table_id', $user->id)->with('transactions')->first();
        }
        // dd(uniqid());
        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['transaction_type'] = 'deposit';
        $wallet_data['cash_in'] = $transaction_amount;
        $wallet_data['cash_out'] = null;
        $wallet_data['description'] = 'Deposit on your wallet';
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount Deposit Successfully', [], 'collection');
        return response($response);
    }

    public function getWalletTransactions(Request $req)
    {

        $user = Auth::user();
        $wallet = Wallet::where('user_type', $this->guard)->where('reference_table_id', $user->id)->orderBy('id', 'desc')->first();
        if ($wallet) {
            $transactions =  $wallet->transactions();
            $transactions = $transactions->orderBy('id', 'desc');
            if ($req->perPage) {
                $transactions = $transactions->paginate($req->perPage);
            } else {
                $transactions = $transactions->paginate(10);
            }
            $transactions = WalletTransactionResource::collection($transactions)->response()->getData(true);
        } else {
            $transactions =  [];
        }
        $response = generateResponse($transactions, true, '', [], 'array');
        return response($response);
    }
    public function getWalletBalance()
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_type', $this->guard)->with('transactions')->where('reference_table_id', $user->id)->first();
        if ($wallet) {
            $data = new WalletResource($wallet);
        } else {
            $data = $wallet;
        }
        $response = generateResponse($data, true, 'Balance is 0', [], 'array');
        return response($response);
    }

    public function depositMoneyToVendorWallet($transaction_amount, $vendor_Id, $order_number)
    {
        $wallet = Wallet::where('user_type', 'vendor')->where('reference_table_id', $vendor_Id)->with('transactions')->first();
        if ($wallet) {
            $opening_balance = $wallet->balance;
            $balance = $wallet->balance + $transaction_amount;
            $wallet->update([
                'balance' => $balance,
            ]);
        } else {
            $opening_balance = 0;
            $balance = $transaction_amount;
            $data['balance'] = $transaction_amount;
            $data['user_type'] = 'vendor';
            $data['reference_table_id'] = $vendor_Id;
            $wallet = Wallet::create($data);
            $wallet = Wallet::where('user_type', 'vendor')->where('reference_table_id', $vendor_Id)->with('transactions')->first();
        }
        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['order_number'] = $order_number;
        $wallet_data['transaction_type'] = 'deposit';
        $wallet_data['cash_in'] = $transaction_amount;
        $wallet_data['cash_out'] = null;
        $wallet_data['description'] = 'Receive Payment after Completion Order # ' . $order_number;
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount Deposit Successfully', [], 'collection');
        return response($response);
    }
    public function RefundAmountToCustomer($total,$customer_id,$order_number)
    {

        $wallet = Wallet::where('user_type', 'customer')->where('reference_table_id', $customer_id)->with('transactions')->first();

        if ($wallet) {
            $opening_balance = $wallet->balance;
            $balance = $wallet->balance + $total;
            $wallet->update([
                'balance' => $balance,
            ]);
        } else {
            $opening_balance = 0;
            $balance = $total;
            $data['balance'] = $total;
            $data['user_type'] = 'customer';
            $data['reference_table_id'] = $customer_id;
            $wallet = Wallet::create($data);
            $wallet = Wallet::where('user_type', 'customer')->where('reference_table_id', $customer_id)->with('transactions')->first();
        }
        // get a wallet balance
        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['transaction_type'] = 'refund';
        $wallet_data['cash_in'] = $total;
        $wallet_data['cash_out'] = null;
        $wallet_data['description'] = 'Amount refund against the order number '.$order_number ;
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount Refund Successfully', [], 'object');
        return response($response);
    }
    public function SendAmountToVendor($vendor_id,$total, $type)
    {

        $wallet = Wallet::where('user_type', $type)->where('reference_table_id', $vendor_id)->with('transactions')->first();

        if ($wallet) {
            $opening_balance = $wallet->balance;
            $balance = $wallet->balance - $total;
            $wallet->update([
                'balance' => $balance,
            ]);
        } else {
            $opening_balance = 0;
            $balance = $total;
            $data['balance'] = $total;
            $data['user_type'] = $type;
            $data['reference_table_id'] = $vendor_id;
            $wallet = Wallet::create($data);
            $wallet = Wallet::where('user_type', $type)->where('reference_table_id', $vendor_id)->with('transactions')->first();
        }
        // get a wallet balance
        $wallet_data['opening_balance'] = $opening_balance;
        $wallet_data['closing_balance'] = $balance;
        $wallet_data['transaction_id'] = uniqid();
        $wallet_data['transaction_type'] = 'withdraw';
        $wallet_data['cash_in'] = null;
        $wallet_data['cash_out'] = $total;
        $wallet_data['description'] = 'Request for a payment';
        $wallet->transactions()->create($wallet_data);
        $data = new WalletResource($wallet);
        $response = generateResponse($data, true, 'Amount Added Successfully', [], 'object');
        return response($response);
    }
}
