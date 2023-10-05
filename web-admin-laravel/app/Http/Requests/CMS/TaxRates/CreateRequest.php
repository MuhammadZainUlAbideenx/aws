<?php

namespace App\Http\Requests\CMS\TaxRates;

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
      $allAttributes['rate'] = trans('messages.fields.rate');
      $allAttributes['is_active'] = trans('messages.fields.is_active');
      $allAttributes['zone_id'] = trans('messages.fields.zone_id');
      $allAttributes['tax_class_id'] = trans('messages.fields.tax_class_id');
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
          'rate' => 'required|numeric|regex:/^[0-99.99]+$/',
          'zone_id' => 'required|exists:zones,id',
          'tax_class_id' => 'required|exists:tax_classes,id',
          'is_active' => 'required|bool',
        ];
    }
}
