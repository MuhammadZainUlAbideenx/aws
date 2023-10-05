<?php

namespace App\Http\Requests\Vendor\Riders;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
      $allAttributes['gender'] = trans('messages.fields.gender');
      $allAttributes['email'] = trans('messages.fields.email');
      $allAttributes['role_id'] = trans('messages.fields.role_id');
      $allAttributes['country_id'] = trans('messages.fields.country_id');
      $allAttributes['state_id'] = trans('messages.fields.state_id');
      $allAttributes['city_id'] = trans('messages.fields.city_id');
      $allAttributes['zip_code'] = trans('messages.fields.zip_code');
      $allAttributes['password'] = trans('messages.fields.password');
      $allAttributes['phone'] = trans('messages.fields.phone');
      $allAttributes['dob'] = trans('messages.fields.dob');
      $allAttributes['address'] = trans('messages.fields.address');
      $allAttributes['is_active'] = trans('messages.fields.is_active');
      // Single Lang Attribute Names

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
          'password' => 'required|same:password_confirmation|min:8',
          'role_id' => 'required|exists:roles,id',
          'country_id' => 'required|exists:countries,id',
          'state_id' => 'required|exists:states,id',
          'city_id' => 'required|exists:cities,id',
          'zip_code' => 'required|max:12|min:5',
          'first_name' => 'required|string|max:25|min:3',
          'last_name' => 'required|string|max:25|min:3',
          'gender' => 'required|string|max:255',
          'email' => 'required|email|unique:riders|max:255',
          'phone' => 'required|string|max:16',
          'dob' => 'required|string|max:255',
          'address' => 'string|max:255',
          'is_active' => 'required|bool',
        ];
    }
}
