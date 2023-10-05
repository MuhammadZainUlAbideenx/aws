<?php

namespace App\Http\Requests\CMS\Languages;

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
          'direction' => 'required|string',
          'code' => 'required|unique:languages,code,'.$this->language->id,
        ];
    }
}
