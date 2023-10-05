<?php

namespace App\Http\Requests\Auth\Vendor;
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
            'email' => 'required|email',
            'social_type' => 'required',
            'google_id' => 'required_if:social_type,google',
            'facebook_id' => 'required_if:social_type,facebook',
        ];
    }

}
