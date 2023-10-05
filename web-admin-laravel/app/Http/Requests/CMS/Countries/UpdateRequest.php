<?php

namespace App\Http\Requests\CMS\Countries;

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
      $allAttributes['iso_code_2'] = trans('messages.fields.iso_code_2');
      $allAttributes['iso_code_3'] = trans('messages.fields.iso_code_3');
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
          'name' => 'required|unique:countries,name,'.$this->country->id,
          'iso_code_2' => 'required|unique:countries,iso_code_2,'.$this->country->id,
          'iso_code_3' => 'required|unique:countries,iso_code_3,'.$this->country->id,
          'is_active' => 'required|bool',
        ];
    }
}
