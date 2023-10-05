<?php

namespace App\Http\Requests\CMS\Roles;

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
        $allAttributes['description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }
      $allAttributes['display_name'] = trans('messages.fields.name');
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
            $allRules['description.'.$language->code] = 'sometimes|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            $allRules['description.'.$language->code] = 'sometimes|string';
          }
        }
      }
      $allRules['display_name'] = 'sometimes|string';
      $allRules['is_active'] = 'sometimes|bool';
      $allRules['permissions'] = 'sometimes';
      return $allRules;
    }
}
