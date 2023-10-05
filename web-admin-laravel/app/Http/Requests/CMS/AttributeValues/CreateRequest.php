<?php

namespace App\Http\Requests\CMS\AttributeValues;

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
    public function attribute_values(){

      $allAttributeValues = [];
      $allLanguages = allLanguages();
      // Multi Lang attribute_values
      foreach ($allLanguages as $language){
        $allAttributeValues['name.'.$language->code] = $language->name.' '.trans('messages.fields.name');
        $allAttributeValues['description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }
      $allAttributeValues['is_active'] = trans('messages.fields.status');

      // Single Lang AttributeValue Names

      return $allAttributeValues;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      // multi language Rules
      $allRules = [];
      $allLanguages = allLanguages();
      $translationRequiredForAllLanguages = translationRequiredForAllLanguages();
      if($translationRequiredForAllLanguages == 1){
        foreach ($allLanguages as $language){
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';

          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';

          }
        }
      }
      // Single Language Rules
      $allRules['is_active'] = 'required';
      return $allRules;
    }
}
