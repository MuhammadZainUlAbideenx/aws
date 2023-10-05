<?php

namespace App\Http\Requests\Auth\Customer;
use App\Http\Requests\WebRequest;


class ForgotPasswordRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:customers',
        ];
    }

}
