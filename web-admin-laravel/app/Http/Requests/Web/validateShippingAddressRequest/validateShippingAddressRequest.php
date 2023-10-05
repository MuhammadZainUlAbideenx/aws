<?php

namespace App\Http\Requests\Web\validateShippingAddressRequest;

use Illuminate\Foundation\Http\FormRequest;

class validateShippingAddressRequest extends FormRequest
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
      $allAttributes['shipping_address.first_name'] = trans('messages.fields.first_name');
      $allAttributes['shipping_address.last_name'] = trans('messages.fields.last_name');
      $allAttributes['shipping_address.email'] = trans('messages.fields.email');
      $allAttributes['shipping_address.city_id'] = trans('messages.fields.city_id');
      $allAttributes['shipping_address.state_id'] = trans('messages.fields.state_id');
      $allAttributes['shipping_address.country_id'] = trans('messages.fields.country_id');
      $allAttributes['shipping_address.zip_code'] = trans('messages.fields.zip_code');
      $allAttributes['shipping_address.address'] = trans('messages.fields.address');
      $allAttributes['shipping_address.phone'] = trans('messages.fields.phone');
      return $allAttributes;

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
          'shipping_address.first_name' => 'required|string|max:255',
          'shipping_address.last_name' => 'required|string|max:255',
          'shipping_address.email' => 'required|email|string',
          'shipping_address.address' => 'required|string|max:255',
          'shipping_address.country_id' => 'required|exists:countries,id',
          'shipping_address.state_id' => 'required|exists:states,id',
          'shipping_address.city_id' => 'required|exists:cities,id',
          'shipping_address.zip_code' => 'required|numeric',
          'shipping_address.phone' => 'required|numeric',
        ];
    }
}
