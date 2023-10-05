<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class PushNotificationRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required_if:user_type,customer,admin',
            'user_type' => 'required',
            'title'=>'required|string',
            'body'=>'required|string',
        ];
    }

}
