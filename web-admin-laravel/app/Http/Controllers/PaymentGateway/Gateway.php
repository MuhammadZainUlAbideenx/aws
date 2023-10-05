<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralControllers\WalletController;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Cart;
use App\Http\Requests\PaymentGatewayRequest;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\Web\PaymentMethodsResource;
use App\Http\Resources\Web\ShippingMethodsResource;
use App\Models\CMSModels\PaymentMethod;
use App\Models\CMSModels\ShippingMethod;
use App\Models\CMSModels\Currency;

use App\Http\Resources\Web\CartResource;

use App\Http\Controllers\WebControllers\ApiOrdersController;

use App\Http\Controllers\PaymentGateway\Stripe;
use App\Http\Controllers\PaymentGateway\Braintree;
use App\Http\Controllers\PaymentGateway\Paypal;
use App\Http\Controllers\PaymentGateway\Paystack;
use App\Http\Resources\General\WalletResource;
use App\Models\CMSModels\Coupon;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\Wallet;
use Hash;

class Gateway extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }
    // Posts
    public function index(PaymentGatewayRequest $request)
    {

        $customer_credentials = [];
        if ($request['coupon_id']) {
            $coupon = Coupon::find($request['coupon_id']);
            if (!$coupon) {
                return response()->json(["message" => "Invalid Resource"]);
            }
        }

        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $customer = auth('customer-api')->user();
            $session_token = Null;
            $customer_credentials['email'] =  Null;
            $customer_credentials['password'] = Null;
        } else {
            $password = uniqid("pass_");
            $unique_id = uniqid("mail_");
            $dummy_customer['first_name'] = $request->shipping_address['first_name'];
            $dummy_customer['last_name'] = $request->shipping_address['last_name'];
            $dummy_customer['email'] =  $unique_id . '@ecom.com';
            $dummy_customer['password'] = Hash::make($password);
            $dummy_customer['is_active'] = 1;
            $customer = Customer::create($dummy_customer);
            $customer_credentials['email'] =  $customer->email;
            $customer_credentials['password'] = $password;

            $session_token = $request->cookie('session_token');
            $cart_items = Cart::withAll()->where('session_token', $session_token)->get();
            foreach ($cart_items as $cart_item) {
                $cart_item->update([
                    'session_token' => Null,
                    'customer_id' =>  $customer->id,
                    'is_ordered' => 0
                ]);
            }
        }
        $payment_method_settings = new PaymentMethodsResource(PaymentMethod::withAll()->where('code', $request->payment_method_code)->first());

        $rider_shipping_method = ShippingMethod::where('id', 6)->first();
        if($rider_shipping_method->is_default == 1){
            $shipping_method_settings = new ShippingMethodsResource(ShippingMethod::withAll()->where('id',6)->first());
            // $shipping_price = 0;
            $shipping_price = $request['shipping_value'];
        }else{
            $shipping_method_settings = new ShippingMethodsResource(ShippingMethod::withAll()->where('id', $request['shipping_id'])->first());
            // $shipping_price = 0;
            if (isset($request->shipping_value)){
                $shipping_price = $request->shipping_value;
            }else{
                $shipping_price = 0;
            }
            foreach ($shipping_method_settings->settings as $setting) {
                if ($setting->name == 'rate') {
                    // $shipping_price = $setting->value;
                    $shipping_price = $shipping_price;
                    break;
                } else {
                    $shipping_price = 0;
                }
            }
        }
        $shipping_price = str_replace(',', '', $shipping_price);


        $cart_items = $customer->cartItems()->where('is_ordered', 0)->get();
        $count_items = count($cart_items);
        $cart_items = CartResource::collection($cart_items);
        $current_currency = session('current_currency');
        $default_currency = session('default_currency');
        $default_currency_shipping_price = $shipping_price * $default_currency->value;
        $current_currency_shipping_price = $shipping_price * $current_currency->value;
        $default_currency_subtotal = $cart_items->sum(function ($q) use ($default_currency) {
            $q = collect($q);
            $default_currency_price = get_price_float($q['default_price']);
            return $default_currency_price;
        });
        $current_currency_subtotal = $cart_items->sum(function ($q) use ($current_currency) {
            $q = collect($q);
            $current_currency_price = get_price_float($q['price']);
            return $current_currency_price;
        });
        $us_currency = Currency::where('code', 'USD')->orWhere('code', 'usd')->first();
        if ($current_currency->code == 'USD' || $current_currency->code == 'usd') {
            $payment_subtotal_price = $current_currency_subtotal;
        } else if ($default_currency->code == 'USD' || $default_currency->code == 'usd') {
            $payment_subtotal_price = $default_currency_subtotal;
        } else {
            $payment_subtotal_price = $current_currency_subtotal * $us_currency->value;
        }
        //shipping_price = 10
        if ($request->coupon_id) {
            // if coupon is aaplied
            $coupon = Coupon::find($request['coupon_id']);
            if ($coupon->discount_type == 1) {
                // Fixed Amount Discount
                $final_discount_amount =  $coupon->amount;
            }
            else if($coupon->discount_type == 2)
            {
                // Percentage Amount Discount
                $coupon_amount = $coupon->amount / 100;
                $final_discount_amount = $coupon_amount * $default_currency_subtotal;

            }
            if ($payment_subtotal_price > $coupon->amount) {
                    if ($coupon->free_shipping) {
                        // if free shipping is applied
                        $payment_total_price = $payment_subtotal_price - $final_discount_amount;
                        $default_currency_total = $default_currency_subtotal - $final_discount_amount;
                        $current_currency_total = $current_currency_subtotal - $final_discount_amount;
                    } else {
                        $payment_total_price = $payment_subtotal_price - $final_discount_amount;
                        $payment_total_price = $payment_total_price + $shipping_price;
                        $default_currency_total = $default_currency_subtotal - $final_discount_amount;
                        $default_currency_total = $default_currency_total + $default_currency_shipping_price;
                        $current_currency_total = $current_currency_subtotal - $final_discount_amount;
                        $current_currency_total = $current_currency_total + $current_currency_shipping_price;
                    }

            } else {
                $response = generateResponse('', true, 'Coupon amount is anvalid ', [], 'object');
                return response($response);
            }
        } else {
            $payment_total_price = $payment_subtotal_price + $shipping_price;
            $default_currency_total = $default_currency_subtotal + $default_currency_shipping_price;
            $current_currency_total = $current_currency_subtotal + $current_currency_shipping_price;
        }
        $request->merge([
            'sub_total' => $payment_subtotal_price,
            'total' => $payment_total_price,
            'default_currency_total' => $default_currency_total,
            'current_currency' => $current_currency->code,
            'current_currency_value' => $current_currency->value,
            'current_currency_total' => $current_currency_total,
            'current_currency_sub_total' => $current_currency_subtotal,
            'current_currency_shipping_price' => $current_currency_shipping_price,
            'default_currency' => $default_currency->code,
            'default_currency_value' => $default_currency->value,
            'usd_currency_value' => $us_currency->value,
            'is_coupon_applied' => $request['coupon_id'] ? 1 : 0,
            'coupon_code' => $request['coupon_id'] ? $coupon->code : null,
            'coupon_amount' => $request['coupon_id'] ? $final_discount_amount : null,
            'coupon_id' => $request['coupon_id'] ? $coupon->id : null,
        ]);

        $customer = new CustomersResource(Customer::withAll()->find($customer->id));
        if ($payment_method_settings->resource != null) {
            if ($customer) {

                if ($payment_method_settings->code == 'stripe') {
                    //stripe
                    $gateway = new Stripe();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $res = $gateway->executePayment($request->all(), $customer);
                    if ($res['captured'] == true && $res['success'] == true) {
                        //Successfully Payment Captured
                        $generate_order = new ApiOrdersController();
                        $is_paid = 1;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                        if ($order_res['success'] == true) {
                            //Successfully Order Generated
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            sendNotification($cart_items);
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else if ($res['success'] == true && $res['captured'] == false) {
                        //Success But Needs 2-Fatctor Auth by Uders Usign authorization_url Generated in res
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                        if ($order_res['success'] == true) {
                            //Successfully Order Generated
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            sendNotification($cart_items);
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        if ($session_token) {
                            $cartItems = $customer->cartItems()->where('is_ordered', 0)->get();
                            foreach ($cart_items as $cart_item) {
                                $cart_item->update([
                                    'session_token' => $session_token,
                                    'customer_id' =>  Null,
                                    'is_ordered' => 0
                                ]);
                            }
                            $customer->delete();
                        }

                        //Error Occurs Duting Payment Api Call E.g Card Invalid..
                        return response()->json($res);
                    }
                } else if ($payment_method_settings->code == 'braintree') {
                    //BrainTree
                    $gateway = new Braintree();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $res = $gateway->executePayment($request->all(), $customer);
                    if ($res['captured'] == true) {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 1;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                        if ($order_res['success'] == true) {
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            sendNotification($cart_items);
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        if ($session_token) {
                            $cartItems = $customer->cartItems()->where('is_ordered', 0)->get();
                            foreach ($cart_items as $cart_item) {
                                $cart_item->update([
                                    'session_token' => $session_token,
                                    'customer_id' =>  Null,
                                    'is_ordered' => 0
                                ]);
                            }
                            $customer->delete();
                        }
                        return response()->json($res);
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'instamojo') {
                    //instamojo
                    $gateway = new Instamojo();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $payment_response = $gateway->executePayment($request->all(), $customer);
                    $res = [];
                    $res['data']['payment_response'] = $payment_response;
                    if ($payment_response->status == 'true') {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {

                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            $res['authorization_required'] =  true;
                            $res['authorization_url'] = $payment_response->data->authorization_url;
                            $res['captured'] = false;
                            $res['return_url'] = "";
                            $res['success'] =  true;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        return response()->json($res);
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'paypal') {
                    //Paypal
                    $gateway = new Paypal();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $res = $gateway->executePayment($request->all(), $customer);
                    if ($res['captured'] == true) {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 1;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                        if ($order_res['success'] == true) {
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            sendNotification($cart_items);
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                        if ($order_res['success'] == true) {
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'paystack') {
                    //paystack
                    $gateway = new Paystack();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $payment_response = $gateway->executePayment($request->all(), $customer);
                    $res = [];
                    $res['data']['payment_response'] = $payment_response;
                    if ($payment_response->status == 'true') {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {

                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            $res['authorization_required'] =  true;
                            $res['authorization_url'] = $payment_response->data->authorization_url;
                            $res['captured'] = false;
                            $res['return_url'] = "";
                            $res['success'] =  true;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        return response()->json($res);
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'mollie') {
                    //mollie
                    $gateway = new Mollie();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $payment_response = $gateway->executePayment($request->all(), $customer);
                    $res = [];
                    $res['data']['payment_response'] = $payment_response;
                    if ($payment_response->status == 'true') {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {

                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            $res['authorization_required'] =  true;
                            $res['authorization_url'] = $payment_response->data->authorization_url;
                            $res['captured'] = false;
                            $res['return_url'] = "";
                            $res['success'] =  true;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        return response()->json($res);
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'razorpay') {
                    //Razorpay
                    $gateway = new Razorpay();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $payment_response = $gateway->executePayment($request->all(), $customer);
                    // $res = $res->toArray();
                    $res = [];
                    $res['data']['payment_response'] = $payment_response;
                    if ($payment_response->status == 'created') {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {

                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            $res['authorization_required'] =  true;
                            $res['authorization_url'] = $payment_response->short_url;
                            $res['captured'] = false;
                            $res['return_url'] = "";
                            $res['success'] =  true;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        return response()->json($res);
                    }
                    return response()->json($res);
                }
                else if ($payment_method_settings->code == 'flutterwave') {
                    //Flutterwave
                    $gateway = new Flutterwave();
                    $gateway->setAuthorizationKeys($payment_method_settings->settings);
                    $payment_response = $gateway->executePayment($request->all(), $customer);
                    $res = [];
                    $res['data']['payment_response'] = $payment_response;
                    if ($payment_response->status == 'success') {
                        $generate_order = new ApiOrdersController();
                        $is_paid = 0;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            $res['authorization_required'] =  true;
                            $res['authorization_url'] = $payment_response->data->link;
                            $res['captured'] = false;
                            $res['return_url'] = "";
                            $res['success'] =  true;
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        return response()->json($res);
                    }
                    return response()->json($res);
                } else if ($payment_method_settings->code == 'paytm') {
                     //Paytm
                     $gateway = new Paytm();
                     $gateway->setAuthorizationKeys($payment_method_settings->settings);
                     $res = $gateway->executePayment($request->all(), $customer);
                     if ($res['msg'] == 'Success') {
                        $res['success'] = true;
                        $res['captured'] = true;
                        $generate_order = new ApiOrdersController();
                        $is_paid = 1;
                        $order_res = $generate_order->create($request->all(), $customer, $is_paid, []);
                        if ($order_res['success'] == true) {
                            $res['data']['order_detail'] = $order_res;
                            $res['data']['customer_credentials'] = $customer_credentials;
                            sendNotification($cart_items);
                            return response()->json($res);
                        } else {
                            return response()->json(["message" => "Contact Support Please, Sorry for in Convi.."]);
                        }
                    } else {
                        if ($session_token) {
                            $cartItems = $customer->cartItems()->where('is_ordered', 0)->get();
                            foreach ($cart_items as $cart_item) {
                                $cart_item->update([
                                    'session_token' => $session_token,
                                    'customer_id' =>  Null,
                                    'is_ordered' => 0
                                ]);
                            }
                            $customer->delete();
                        }
                        return response()->json($res);
                    }
                    return response()->json($res);
                } else if ($payment_method_settings->code == 'cash_on_delivery') {
                    $res['success'] = true;
                    $res['captured'] = true;
                    $res['authorization_required'] = false;
                    $res['return_url'] = '';
                    $res['authorization_url'] = '';
                    $data['receipt_email'] = $customer->email;
                    $data['shipping_details'] = $request->shipping_address;
                    $data['capture_id'] = 'cash_on_delivery';
                    $res['data'] = $data;
                    $generate_order = new ApiOrdersController();
                    $is_paid = 0;
                    $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                    if ($order_res['success'] == true) {

                        sendNotification($cart_items);
                        $res['data']['intent_id'] = $order_res;
                        $res['data']['capture_id'] = $order_res;
                        $res['data']['order_detail'] = $order_res;
                        $res['data']['customer_credentials'] = $customer_credentials;
                        $res['data']['metadata'] = null;
                        return response()->json($res);
                    } else {
                        $data_error['message'] = "Contact Support Please, Sorry for in Convi..";
                        $res['data'] = $data_error;
                        return response()->json($res);
                    }
                } else if ($payment_method_settings->code == "payment_wallet") {
                    if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
                        $res = [];
                        $res['success'] = true;
                        $res['captured'] = true;
                        $res['authorization_required'] = false;
                        $res['return_url'] = '';
                        $res['authorization_url'] = '';
                        $data['receipt_email'] = $customer->email;
                        $data['shipping_details'] = $request->shipping_address;
                        $data['capture_id'] = 'payment_wallet';
                        $res['data'] = $data;
                        $wallet =  Wallet::where('user_type', 'customer')->where('reference_table_id', $customer->id)->with('transactions')->first();
                        if ($wallet) {
                            $opening_balance = $wallet->balance;
                            if ($wallet->balance == 0 || $wallet->balance < $payment_total_price) {
                                $response = generateResponse('', false, 'InSufficient Balance', [], 'object');
                                return response($response);
                            } else {

                                $generate_order = new ApiOrdersController();
                                $is_paid = 1;
                                $order_res = $generate_order->create($request->all(), $customer, $is_paid, $res);
                                if ($order_res['success'] == true) {
                                    $balance = $wallet->balance - $payment_total_price;
                                    $wallet->update([
                                        'balance' => $balance,
                                    ]);
                                    $wallet_data['opening_balance'] = $opening_balance;
                                    $wallet_data['closing_balance'] = $balance;
                                    $wallet_data['order_number'] = $order_res['order_number'];
                                    $wallet_data['transaction_id'] = uniqid();
                                    $wallet_data['transaction_type'] = 'purchase';
                                    $wallet_data['cash_in'] = null;
                                    $wallet_data['cash_out'] = $payment_total_price;
                                    $wallet_data['description'] = 'Order through wallet (' . $order_res['order_number'] . ' )';
                                    $wallet->transactions()->create($wallet_data);
                                    $data = new WalletResource($wallet);
                                    sendNotification($cart_items);
                                    $res['data']['intent_id'] = $order_res;
                                    $res['data']['capture_id'] = $order_res;
                                    $res['data']['order_detail'] = $order_res;
                                    $res['data']['customer_credentials'] = $customer_credentials;
                                    $res['data']['metadata'] = null;
                                    return response()->json($res);
                                } else {
                                    $data_error['message'] = "Contact Support Please, Sorry for in Convi..";
                                    $res['data'] = $data_error;
                                    return response()->json($res);
                                }
                            }
                        } else {
                            $response = generateResponse('', false, 'InSufficient Balance', [], 'object');
                            return response($response);
                        }
                    } else {
                        $response = generateResponse('', false, 'Please Login', [], 'object');
                        return response($response);
                    }
                } else {
                    $res = [
                        'message' => 'Method Not Implemented'
                    ];
                    return response()->json($res);
                }
            } else {
                return response("No Such Customer Exists", 404);
            }
        } else {
            return response("No Such Payment Method Exists", 404);
        }
    }
    public function verifyPayment(Request $request)
    {

        $data = $request->all();
        foreach ($data as $data) {
            $data = $data;
        }

        $payment_method_settings = new PaymentMethodsResource(PaymentMethod::withAll()->where('code', $data[0]['params']['payment_method_code'])->first());
        if ($payment_method_settings->code == 'stripe') {
            $strpie = new Stripe();
            $strpie->setAuthorizationKeys($payment_method_settings->settings);
            $response = $strpie->verifyPayment($data[0]['params']);
            if ($response['captured'] == true) {
                if (isset($data[0]['order_id'])) {
                    $order_id = Order::find($data[0]['order_id']);
                    $order_id->update([
                        'transaction_status' => 'captured',
                        'is_paid' => 1
                    ]);
                }
                if (isset($response['data']['metadata']->payment_type) && $response['data']['metadata']->payment_type == 'wallet') {
                    $wallet = new WalletController;
                    $wallet->depositAfterPaymentVerification($response['data']['metadata']->amount);
                }
            }
            return response()->json($response);
        } else if ($payment_method_settings->code == 'paypal') {
            $gateway = new Paypal();
            $gateway->setAuthorizationKeys($payment_method_settings->settings);
            $response = $gateway->verifyPayment($data[0]['params']);
            if ($response['captured'] == true) {
                $order_id = Order::find($data[0]['order_id']);
                $order_id->update([
                    'transaction_status' => 'captured',
                    'is_paid' => 1
                ]);
            }
            return response()->json($response);
        }
        else if ($payment_method_settings->code == 'paystack') {
            $response = ["captured" => 'captured'];
            $order_id = Order::find($data[0]['order_id']);
            $order_id->update([
                'transaction_status' => 'auto-captured',
                'is_paid' => 1
            ]);
            return response()->json($response);
        }
        else if ($payment_method_settings->code == 'mollie') {
            $response = ["captured" => 'captured'];
            $order_id = Order::find($data[0]['order_id']);
            $order_id->update([
                'transaction_status' => 'auto-captured',
                'is_paid' => 1
            ]);
            return response()->json($response);
        }
        else if ($payment_method_settings->code == 'razorpay') {
            // $gateway = new Razorpay();
            // $gateway->setAuthorizationKeys($payment_method_settings->settings);
            // $response = $gateway->verifyPayment($data[0]['params']);
            $response = ["captured" => 'captured'];
            // if ($response['captured'] == true) {

            $order_id = Order::find($data[0]['order_id']);
            $order_id->update([
                'transaction_status' => 'auto-captured',
                'is_paid' => 1
            ]);
            // }
            return response()->json($response);
        }
        else if ($payment_method_settings->code == 'flutterwave') {
            // $gateway = new Razorpay();
            // $gateway->setAuthorizationKeys($payment_method_settings->settings);
            // $response = $gateway->verifyPayment($data[0]['params']);
            $response = ["captured" => 'captured'];
            // dd($request[0]->flutterwave_payment_status);
            // if ($response['captured'] == true) {
            if ($data[0]['params']['status'] != 'cancelled') {
                $order_id = Order::find($data[0]['order_id']);
                $order_id->update([
                    'transaction_status' => 'auto-captured',
                    'is_paid' => 1
                ]);
            }

            // }
            return response()->json($response);
        } else if ($payment_method_settings->code == 'instamojo') {
             $gateway = new Instamojo();
             $gateway->setAuthorizationKeys($payment_method_settings->settings);
             $response = $gateway->verifyPayment($data[0]['params']);
             return response()->json($response);
            $res = [
                'message' => 'Method Not Implemented'
            ];
            return response()->json($res);
        } else {
            $res = [
                'message' => 'Method Not Implemented'
            ];
            return response()->json($res);
        }
    }
}
