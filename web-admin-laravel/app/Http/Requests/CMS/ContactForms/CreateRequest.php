<?php

namespace App\Http\Requests\CMS\ContactForms;

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
      }
      $allAttributes['name'] = trans('messages.fields.name');
      $allAttributes['email'] = trans('messages.fields.email');
      $allAttributes['subject'] = trans('messages.fields.subject');
      $allAttributes['message'] = trans('messages.fields.message');
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
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_verified){
          }
        }
      }
      // Single Language Rules
      $allRules['name'] = 'required|string';
      $allRules['email'] = 'required|email';
      $allRules['subject'] = 'required|string';
      $allRules['message'] = 'required|string';
      return $allRules;
    }
}
