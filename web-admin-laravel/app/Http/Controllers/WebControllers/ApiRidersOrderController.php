<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Riders\UpdateBasicProfileRequest;
use App\Http\Requests\Vendor\Riders\UpdateImageRequest;
use App\Http\Requests\Web\Payouts\CreateRequest;
use App\Http\Resources\Web\OrdersResource;
use Illuminate\Http\Request;
use App\Http\Resources\Web\RiderOrdersResource;
use App\Http\Resources\Web\RidersResource;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\PayoutRequest;
use App\Models\CMSModels\Rider;
use App\Models\CMSModels\RiderShipping;
use App\Models\CMSModels\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ApiRidersOrderController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:rider-api');
    }
    public function RiderPendingOrderList(Request $request)
    {
        $rider = Auth::user();
        $orders = Order::withAll()->with('payment_method')->where('order_status_id', 3)->where('vendor_id', $rider->vendor_id)->whereNull('rider_id')->get();
        $orders = RiderOrdersResource::collection($orders)->response()->getData(true);
        $response = generateResponse($orders, true, '', [], 'collection');
        return response($response);
    }
    public function RiderOrderList(Request $request)
    {
        $rider = Auth::user();
        $orders = Order::withAll()->with('payment_method')->where('rider_id', $rider->id)->get();
        $orders = RiderOrdersResource::collection($orders)->response()->getData(true);
        $response = generateResponse($orders, true, '', [], 'collection');
        return response($response);
    }

    public function RiderUpdateStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_status_code' => 'required',
            'order_id' => 'required',
            'order_status_reason' => 'required_if:order_status_code,20'
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $rider = Auth::user();
        $rider_id = $rider->id;

        $rider = RiderShipping::where('vendor_id', $rider->vendor_id)->first();
        $rider_commission_type = $rider->commission_type;
        $rider_commission_rate = $rider->commission_rate;
        $order = Order::where('id', $request->order_id)->first();
        if ($order) {
            if ($order->order_status_id == 6) {
                $message = 'Status Cannot Changed of Delivered Product';
                $response = generateResponse('', false, $message, [], 'collection');
                return $response;
            } else {

                $data['order_status_id'] = $request->order_status_code;
                $data['rider_id'] = $rider_id;
                $data['order_status_reason'] =  $request->order_status_reason;
                $order = $order->update($data);
                if ($request->order_status_code == 6) {
                    $wallet = Wallet::where('user_type', 'rider')->where('reference_table_id', $rider_id)->with('transactions')->first();
                    // Add commission to Rider Account
                    if ($rider_commission_type == 1) {
                        // Fixed Commission
                        $calculated_commission_rate =  $rider_commission_rate;
                    }
                    if ($rider_commission_type == 0) {
                        $order = Order::where('id', $request->order_id)->first();
                        // Percentage Commission
                        $total_price = $order->total;
                        $calculated_commission_rate = ($rider_commission_rate / 100) * $total_price;
                    }
                    if ($wallet) {
                        $balance = $wallet->balance + $calculated_commission_rate;
                        $wallet->update([
                            'balance' => $balance,
                        ]);
                    } else {
                        $data['balance'] = $calculated_commission_rate;
                        $data['user_type'] = 'rider';
                        $data['reference_table_id'] = $rider_id;
                        $wallet = Wallet::create($data);
                    }
                    $wallet_data['transaction_id'] = uniqid();
                    $wallet_data['transaction_type'] = 'deposit';
                    $wallet_data['cash_in'] = $calculated_commission_rate;
                    $wallet_data['cash_out'] = null;
                    $wallet_data['description'] = 'Commission added on your wallet';
                    $wallet->transactions()->create($wallet_data);
                }
                $order = Order::withAll()->with('customer')->where('id', $request->order_id)->where('rider_id', $rider_id)->first();
                $order = new RiderOrdersResource($order);
                $message = 'Status successfully updated';
                $response = generateResponse($order, true, $message, [], 'collection');
                return $response;
            }
        }

        $message = 'Status not updated';
        $response = generateResponse('', false, $message, [], 'object');
        return $response;
        //   return response()->json(["state" => "success", "message" => trans('messages.response.orders.update_status_success'),"orders" => $rider_data] );
    }

    public function RiderOrderDetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $orders = Order::withAll()->withAllDetail()->where('id', $request->order_id)->first();
        if ($orders) {
            $orders = new RiderOrdersResource($orders);
            $response = generateResponse($orders, true, '', [], 'collection');
            return response($response);
        } else {
            $message = 'No Order Against this ID';
            $response = generateResponse('', false, $message, [], 'object');
            return $response;
        }
    }

    public function RiderProfile(Request $request)
    {
        $rider = Auth::user();
        // $rider_id = $rider->id;
        $rider = Rider::withAll()->where('id', $rider->id)->first();
        $rider = new RidersResource($rider);
        $response = generateResponse($rider, true, '', [], 'object');
        return response($response);
    }
    public function RiderUpdateImage(UpdateImageRequest $request)
    {
        if (!file_exists(public_path('riders'))) {
            mkdir(public_path('riders'), 0755, true);
        }
        if (!file_exists(public_path('riders/profile_images'))) {
            mkdir(public_path('riders/profile_images'), 0755, true);
        }
        $rider = Auth::user();
        $file = $request->file('file');
        $filename = $rider->first_name . '_' . $file->getClientOriginalName();
        $file_resize = Image::make($file->getRealPath());
        $file_resize->save(public_path('riders/profile_images/' . $filename));
        $file_url = '/api/riders/profile_images/' . $filename;
        if ($rider->profile_image_path) {
            $old_profile_image = explode('/api', $rider->profile_image_path);
            $old_profile_image = public_path() . $old_profile_image[1];
            if (file_exists($old_profile_image)) {
                unlink($old_profile_image);
            }
        }
        $rider->update([
            'profile_image_path' => $file_url,
        ]);
        $data['user'] = new RidersResource($rider);
        $response = generateResponse($data, true, trans('messages.response.web.image_uploaded'), [], 'object');
        return response($response);
        // return response()->json(['profile_image_path' => $rider->profile_image_path, 'success' => true,'message' => 'your Profile image Has been Uploaded'], 200);
    }

    public function RiderUpdateProfile(UpdateBasicProfileRequest $request)
    {
        $rider = Auth::user();
        $updated = $rider->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'phone' => $request->phone]);
        if ($updated) {
            $data['user'] = new RidersResource($rider);
            $response = generateResponse($data, true, trans('messages.response.profile.update_success'), [], 'object');
            return response($response);
        }
    }

    public function RiderSearchOrder(Request $request)
    {
        $rider = Auth::user();
        $rider_id = $rider->id;
        $validator = Validator::make($request->all(), [
            'order_number' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $orders = Order::withAll()->where('order_number', 'LIKE', '%' . $request->order_number . '%')->where('rider_id', $rider_id)->get();
        $orders = OrdersResource::collection($orders);
        $response = generateResponse($orders, true, '', [], 'object');
        return response($response);
    }

    public function createPayoutRequest(CreateRequest $request)
    {
        $data = $request->all();
        $wallet = Wallet::where('user_type', 'rider')->where('reference_table_id', $request->rider_id)->first();
        if ($wallet) {
            if ($request->amount <= $wallet->balance) {
                $data['status'] = 1;
                $data['vendor_id'] = null;
                $created = PayoutRequest::create($data);
                if ($created) {
                    $response = generateResponse($created, True, trans('messages.response.web.payout_request_created_successfully'), [], 'object');
                    return response($response);
                }
            } else {
                $response = generateResponse($wallet, false, trans('messages.response.web.insufficient_balance'), [], 'object');
                return response($response);
            }
        } else {
            $response = generateResponse($wallet, false, trans('messages.response.web.insufficient_balance'), [], 'object');
            return response($response);
        }
    }
}
