<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class WalletRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'balance' => 'required|integer',
        ];
    }

}
