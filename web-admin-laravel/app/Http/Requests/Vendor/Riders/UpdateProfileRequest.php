<?php

namespace App\Http\Requests\Vendor\Riders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function attributes(){

      $allAttributes = [];
      $allAttributes['first_name'] = trans('messages.fields.first_name');
      $allAttributes['last_name'] = trans('messages.fields.last_name');
      $allAttributes['dob'] = trans('messages.fields.dob');


    //  $allAttributes['email'] = trans('messages.fields.email');
      $allAttributes['password'] = trans('messages.fields.password');

      return $allAttributes;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'is_pass' => 'required',
          'dob' => 'required|string',
          'password' => 'required_if:is_pass,==,true|min:8|same:password_confirmation',
          'first_name' => 'required|string|max:25|min:3',
          'last_name' => 'required|string|max:25|min:3',

        //  'email' => 'required|email|string|max:255|unique:vendors',
        ];
    }
}
