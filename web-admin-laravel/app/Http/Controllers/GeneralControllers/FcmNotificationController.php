<?php

namespace App\Http\Controllers\GeneralControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\FcmNotificationRequest;
use App\Http\Requests\General\PushNotificationRequest;
use App\Models\CMSModels\FcmToken;
use App\Models\CMSModels\Rider;
use Illuminate\Support\Facades\Auth;

class FcmNotificationController extends Controller
{
    public $guard;
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
    public function storeToken(FcmNotificationRequest $request)
    {
        $device = $request->device_id;
        $user = Auth::user();
        $user_id = $user->id;
        $oldTokens = FcmToken::where('device_id', $device)->delete();
        if ($this->guard == 'admin') {
            $user_id = 1;
        }
        FcmToken::create(['user_id' => $user_id, 'user_type' => $this->guard, 'device_key' => $request->fcm_token, 'device_id' => $device]);
        $response = generateResponse('', true, 'Token stored Successfully', [], 'object');
        return response($response);
    }
    public function sendPushNotification(PushNotificationRequest $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        if ($request->user_type == 'rider') {
            $riders_ids = Rider::where('store_type', 'admin')->where('is_active',1)->pluck('id')->toArray();
            $FcmToken = FcmToken::where('user_type', $request->user_type)->whereIn('user_id', $riders_ids)->whereNotNull('device_key')->pluck('device_key')->toArray();
        } else {
            $FcmToken = FcmToken::where('user_id', $request->user_id)->where('user_type', $request->user_type)->whereNotNull('device_key')->pluck('device_key')->toArray();
        }
        $serverKey = config('services.firebase.firebase.server_key');


        // If conditions based on requirements
        // $data = [
        //     "registration_ids" => $FcmToken,
        //     "notification" => [
        //         "title" => $request->title,
        //         "body" => $request->body,
        //         'data'=>$request->link

        //     ],
        //     "data" => [
        //         "routeApp" => "/audioCall",
        //         "channel" => "$request->channel_name",
        //         "channel_token" => "$request->channel_token"
        //     ]
        // ];

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,

            ]
        ];

        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        $response = generateResponse($result, true, 'Push Notification Send Successfully', [], 'collection');
        return response($response);
    }
}
