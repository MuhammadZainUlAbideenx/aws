<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class FetchMessageRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sender_id' => 'required|integer',
            'receiver_id'=>'required|integer',
            'order_number'=>'required',
        ];
    }

}
