<?php

namespace App\Http\Requests\Vendor\VendorProfile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
      $allAttributes['name'] = trans('messages.fields.name');
    //  $allAttributes['email'] = trans('messages.fields.email');
      $allAttributes['password'] = trans('messages.fields.password');
      $allAttributes['dob'] = trans('messages.fields.dob');


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
        //   'dob' => 'required|string',
          'password' => 'required_if:is_pass,==,true|min:8|same:password_confirmation',
          'name' => 'required|string|max:25|min:3',
        //  'email' => 'required|email|string|max:255|unique:vendors',
        ];
    }
}
