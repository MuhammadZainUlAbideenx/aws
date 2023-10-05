<?php

namespace App\Http\Requests\CMS\Customers;

use Illuminate\Foundation\Http\FormRequest;

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
      $allAttributes['first_name'] = trans('messages.fields.first_name');
      $allAttributes['last_name'] = trans('messages.fields.last_name');
      $allAttributes['gender'] = trans('messages.fields.gender');
      $allAttributes['email'] = trans('messages.fields.email');
      $allAttributes['password'] = trans('messages.fields.password');
      $allAttributes['phone'] = trans('messages.fields.phone');
      $allAttributes['dob'] = trans('messages.fields.dob');
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
          'password' => 'nullable|same:password_confirmation|min:8',
          'first_name' => 'required|string|max:25|min:3',
          'last_name' => 'string|max:25|min:3',
          'gender' => 'string|max:255',
          'email' => 'email|max:255|unique:customers,email,'.$this->customer->id,
          'phone' => 'string|max:16|min:4',
          'address' => 'required_with:city_id,state_id,zip_code,country_id',
          'country_id' => 'required_with:address',
          'state_id' => 'required_with:address',
          'city_id' => 'required_with:address',
          'zip_code' => 'required_with:address',
          'dob' => 'string|max:255',
          'is_active' => 'required|bool',
        ];
    }
}
