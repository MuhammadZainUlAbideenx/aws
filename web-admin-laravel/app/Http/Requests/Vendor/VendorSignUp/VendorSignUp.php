<?php

namespace App\Http\Requests\Vendor\VendorSignUp;

use Illuminate\Foundation\Http\FormRequest;

class VendorSignUp extends FormRequest
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
      $allAttributes['email'] = trans('messages.fields.email');
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
          'password' => 'required|min:8|same:password_confirmation',
          'name' => 'required|string|max:255',
          'email' => 'required|email|string|max:255|unique:vendors',
        ];
    }
}
