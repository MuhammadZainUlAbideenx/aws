<?php

namespace App\Http\Requests\CMS\Faqs;

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
        $allAttributes['question.'.$language->code] = $language->name.' '.trans('messages.fields.question');
        $allAttributes['answer.'.$language->code] = $language->name.' '.trans('messages.fields.answer');
      }
      $allAttributes['is_active'] = trans('messages.fields.status');
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
            $allRules['question.'.$language->code] = 'required|string';
            $allRules['answer.'.$language->code] = 'required|string';

          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['question.'.$language->code] = 'required|string';
            $allRules['answer.'.$language->code] = 'required|string';

          }
        }
      }
      // Single Language Rules
      $allRules['product_id'] = 'required';
      $allRules['is_active'] = 'required';
      return $allRules;
    }
}
