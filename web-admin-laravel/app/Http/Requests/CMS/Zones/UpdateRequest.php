<?php

namespace App\Http\Requests\CMS\Zones;

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
      $allAttributes['country_id'] = trans('messages.fields.country');
      $allAttributes['code'] = trans('messages.fields.code');
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
          'name' => 'required|unique:zones,name,'.$this->zone->id,
          'country_id' => 'required|exists:countries,id',
          'code' => 'required|unique:zones,code,'.$this->zone->id,
          'is_active' => 'required|bool',
        ];
    }
}
