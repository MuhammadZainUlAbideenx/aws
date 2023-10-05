<?php

namespace App\Http\Requests\CMS\ShippingMethods;

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
      $allAttributes['is_active'] = trans('messages.fields.status');
      $allAttributes['is_default'] = trans('messages.fields.is_default');

      // Fixed Shipping
      $allAttributes['settings.rate'] = trans('messages.fields.rate');
      $allAttributes['settings.currency_code'] = trans('messages.fields.currency_code');


      // UPS Shipping
      $allAttributes['settings.mode'] = trans('messages.fields.mode');
      $allAttributes['active_option_indexes'] = trans('messages.fields.active_option_indexes');
      $allAttributes['settings.access_key'] = trans('messages.fields.access_key');
      $allAttributes['settings.username'] = trans('messages.fields.username');
      $allAttributes['settings.password'] = trans('messages.fields.password');
      $allAttributes['settings.pickup_method'] = trans('messages.fields.pickup_method');
      $allAttributes['settings.address'] = trans('messages.fields.address');
      $allAttributes['settings.country'] = trans('messages.fields.country');
      $allAttributes['settings.state'] = trans('messages.fields.state');
      $allAttributes['settings.country'] = trans('messages.fields.country');
      $allAttributes['settings.city'] = trans('messages.fields.city');
      $allAttributes['settings.postal_code'] = trans('messages.fields.postal_code');


      // Weight Shipping
      $allAttributes['settings.weight'] = trans('messages.fields.weight');
      $allAttributes['settings.rate'] = trans('messages.fields.rate');


      $allAttributes['is_active'] = trans('messages.fields.status');
      $allAttributes['is_default'] = trans('messages.fields.is_default');
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
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';

          }
        }
      }
      if($this->id == 1){ // Fixed Shipping
        $allRules['settings.rate'] = 'required';
        $allRules['settings.currency_code'] = 'required|string|max:3|min:2';
      }
      else if($this->id == 4){ // UPS Shipping
        $allRules['settings.mode'] = 'required|string';
        $allRules['active_option_indexes'] = 'required';
        $allRules['settings.access_key'] = 'required|string';
        $allRules['settings.username'] = 'required';
        $allRules['settings.password'] = 'required';
        $allRules['settings.pickup_method'] = 'required';
        $allRules['settings.address'] = 'required';
        $allRules['settings.country'] = 'required';
        $allRules['settings.state'] = 'required';
        $allRules['settings.city'] = 'required';
        $allRules['settings.postal_code'] = 'required';
      }
      else if($this->id == 5){ // Weight Shipping
        $allRules['settings.weight'] = 'required|numeric';
        $allRules['settings.rate'] = 'required|numeric';
      }

      // Single Language Rules
      $allRules['is_active'] = 'required';
      $allRules['is_default'] = 'required';
      return $allRules;
    }
}
