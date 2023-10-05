<?php

namespace App\Http\Requests\CMS\Currencies;

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
      $allAttributes['name'] = trans('messages.fields.name');
      $allAttributes['code'] = trans('messages.fields.code');
      $allAttributes['direction'] = trans('messages.fields.direction');
      $allAttributes['symbol'] = trans('messages.fields.symbol');
      $allAttributes['decimal_places'] = trans('messages.fields.decimal_places');
      $allAttributes['value'] = trans('messages.fields.value');
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
          'name' => 'required|string|max:255',
          'code' => 'required|string|unique:currencies,code,'.$this->currency->id,
          'symbol' => 'required|string|unique:currencies,symbol,'.$this->currency->id,
          'direction' => 'required|string',
          'decimal_places' => 'required|numeric|gt:0',
          'value' => 'required',
        ];
    }
}
