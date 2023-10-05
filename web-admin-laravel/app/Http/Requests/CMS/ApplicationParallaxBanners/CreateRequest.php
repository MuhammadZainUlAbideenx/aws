<?php

namespace App\Http\Requests\CMS\ApplicationParallaxBanners;

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
        $allAttributes['image.'.$language->code] = $language->name.' '.trans('messages.fields.name');
        $allAttributes['name.'.$language->code] = $language->name.' '.trans('messages.fields.name');
        $allAttributes['description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }
      $allAttributes['expiry_date'] = trans('messages.fields.expiry_date');
      $allAttributes['website_url'] = trans('messages.fields.website_url');
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
            $allRules['image.'.$language->code] = 'required';
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
              $allRules['image.'.$language->code] = 'required';

          }
        }
      }
      // Single Language Rules
      $allRules['expiry_date'] = 'required|string';
      $allRules['website_url'] = 'required|url';
      $allRules['is_active'] = 'required|bool';
      return $allRules;
    }
}
