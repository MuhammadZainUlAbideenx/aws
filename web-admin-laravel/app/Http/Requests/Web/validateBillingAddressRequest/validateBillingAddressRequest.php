<?php

namespace App\Http\Requests\Web\validateBillingAddressRequest;

use Illuminate\Foundation\Http\FormRequest;

class validateBillingAddressRequest extends FormRequest
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
      $allAttributes['billing_address.first_name'] = trans('messages.fields.first_name');
      $allAttributes['billing_address.last_name'] = trans('messages.fields.last_name');
      $allAttributes['billing_address.email'] = trans('messages.fields.email');
      $allAttributes['billing_address.city_id'] = trans('messages.fields.city_id');
      $allAttributes['billing_address.state_id'] = trans('messages.fields.state_id');
      $allAttributes['billing_address.country_id'] = trans('messages.fields.country_id');
      $allAttributes['billing_address.zip_code'] = trans('messages.fields.zip_code');
      $allAttributes['billing_address.address'] = trans('messages.fields.address');
      $allAttributes['billing_address.phone'] = trans('messages.fields.phone');
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
          'billing_address.first_name' => 'required|string|max:255',
          'billing_address.last_name' => 'required|string|max:255',
          'billing_address.email' => 'required|email|string',
          'billing_address.address' => 'required|string|max:255',
          'billing_address.country_id' => 'required|exists:countries,id',
          'billing_address.state_id' => 'required|exists:states,id',
          'billing_address.city_id' => 'required|exists:cities,id',
          'billing_address.zip_code' => 'required|numeric',
          'billing_address.phone' => 'required|numeric',
        ];
    }
}
