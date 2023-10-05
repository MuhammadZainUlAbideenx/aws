<?php

namespace App\Http\Requests\Auth\Customer;
use App\Http\Requests\WebRequest;


class SocialLoginRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|email',
            'google_id' => 'required_if:social_type,google',
            'facebook_id' => 'required_if:social_type,facebook',
            'social_type' => 'required',
        ];
    }

}
