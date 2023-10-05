<?php

namespace App\Http\Requests\CMS\Countries;

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
          'name' => 'required|string|unique:countries|max:255',
          'iso_code_2' => 'required|string|unique:countries',
          'iso_code_3' => 'required|string|unique:countries',
          'is_active' => 'required|bool',
        ];
    }
}
