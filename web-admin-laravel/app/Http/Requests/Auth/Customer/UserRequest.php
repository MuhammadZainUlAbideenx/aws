<?php

namespace App\Http\Requests\Auth\Customer;

use App\Http\Requests\WebRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:customers,email,'.Auth::guard('customer-api')->user->id,
            'password' => 'sometimes|required|string|min:8|max:255|confirmed',
        ];
    }
}
