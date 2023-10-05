<?php

namespace App\Http\Requests\CMS\AboutUs;

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
        $allAttributes['text.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }
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
            $allRules['text.'.$language->code] = 'required|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            $allRules['text.'.$language->code] = 'required|string';

          }
        }
      }
      return $allRules;
    }
}
