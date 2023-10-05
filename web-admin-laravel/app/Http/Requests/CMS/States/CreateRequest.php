<?php

namespace App\Http\Requests\CMS\States;

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
      $allAttributes['code'] = trans('messages.fields.code');
      $allAttributes['country_id'] = trans('messages.fields.country_id');
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
          'name' => 'required|unique:states|string|max:255',
          'country_id' => 'required|exists:countries,id',
          'code' => 'required|string|max:255',
          'is_active' => 'required|bool',
          'zone_id'=> 'exists:zones,id|nullable',
        ];
    }
}
