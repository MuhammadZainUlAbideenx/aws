<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class MessageRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message' => 'required|string',
            'sender_id' => 'required|integer',
            'receiver_id'=>'required|integer',
            'user_type'=>'required',
        ];
    }

}
