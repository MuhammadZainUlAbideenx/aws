<?php

namespace App\Http\Requests\CMS\Products;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class AttributesRequest extends FormRequest
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

      foreach ($allLanguages as $language){
        $allAttributes['attributes.*.values.*.value.'.$language->code] = $language->name.' '.trans('messages.fields.value');
      }
        $allAttributes['attribute_id'] = trans('messages.fields.attribute');
        $allAttributes['combinations.*.sku'] = trans('messages.fields.sku');
        $allAttributes['combinations.*.stock'] = trans('messages.fields.stock');
        $allAttributes['combinations.*.price'] = trans('messages.fields.price');
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
      $allSettings = allSettings();
      $allRules = [];
      $allLanguages = allLanguages();
      $translationRequiredForAllLanguages = translationRequiredForAllLanguages();
      if($translationRequiredForAllLanguages == 1){
        foreach ($allLanguages as $language){
            $allRules['attributes.*.values.*.value.'.$language->code] = 'required|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            $allRules['attributes.*.values.*.value.'.$language->code] = 'required|string';
          }
        }
      }
      $allRules['attributes.*.id'] = 'required';
      $allRules['combinations.*.sku'] = 'required|distinct:strict';
      $allRules['combinations.*.stock'] = 'required|integer';
      $allRules['combinations.*.price'] = 'required';
      return $allRules;
    }
}
