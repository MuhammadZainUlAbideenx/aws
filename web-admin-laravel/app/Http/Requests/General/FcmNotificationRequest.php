<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class FcmNotificationRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'device_id' => 'required|string',
            'fcm_token' => 'required|string',
        ];
    }

}
