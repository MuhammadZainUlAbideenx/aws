<?php

namespace App\Http\Requests\Auth\Admin;
use App\Http\Requests\WebRequest;


class LoginRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8|max:255',
        ];
    }

}
