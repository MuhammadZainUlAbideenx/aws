<?php

namespace App\Http\Requests\Web\CustomerSignUp;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSignUp extends FormRequest
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
          'first_name' => 'required|string|max:255',
          'email' => 'required|email|string|max:255|unique:customers',
        ];
    }
}
