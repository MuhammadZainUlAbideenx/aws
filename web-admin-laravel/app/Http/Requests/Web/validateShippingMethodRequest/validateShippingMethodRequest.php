<?php

namespace App\Http\Requests\Web\validateShippingMethodRequest;

use Illuminate\Foundation\Http\FormRequest;

class validateShippingMethodRequest extends FormRequest
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
      $allAttributes['shipping_id'] = trans('messages.fields.shipping_method');

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
          'shipping_id' => 'required|exists:shipping_methods,id'
        ];
    }
}
