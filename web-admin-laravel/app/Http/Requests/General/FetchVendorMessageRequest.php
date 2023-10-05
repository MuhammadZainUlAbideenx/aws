<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class FetchVendorMessageRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rider_id' => 'required|integer',
        ];
    }

}
