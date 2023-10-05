<?php

namespace App\Http\Requests\CMS\ContentPages;

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
      $allLanguages = allLanguages();
      // Multi Lang attributes
      foreach ($allLanguages as $language){
        $allAttributes['name.'.$language->code] = $language->name.' '.trans('messages.fields.name');
        $allAttributes['description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }
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
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';


          }
        }
      }
      // Single Language Rules
      $allRules['is_active'] = 'required|bool';
      return $allRules;
    }
}
