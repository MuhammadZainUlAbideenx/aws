<?php

namespace App\Http\Requests\CMS\PaymentMethods;

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
      $allAttributes['image_id'] = trans('messages.fields.image');

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
        $allRules['settings.account_title'] = 'required';
        $allRules['settings.account_number'] = 'required|string';
        $allRules['settings.bank_name'] = 'required|string';
        $allRules['settings.code'] = 'required|string';
        $allRules['settings.iban'] = 'required|string';
        $allRules['settings.swift'] = 'required|string';
      }
      else if($this->id == 2){ // UPS Shipping
        $allRules['settings.mode'] = 'required|string';
      }
    //   else if($this->id == 3){ // Weight Shipping
    //     $allRules['settings.mode'] = 'required|string';
    //     $allRules['settings.merchant_id'] = 'required|string';
    //   }
      else if($this->id == 4){ // Weight Shipping
        $allRules['settings.mode'] = 'required|string';
        $allRules['settings.secret_key'] = 'required|string';
        $allRules['settings.publisher_key'] = 'required|string';
      }
      else if($this->id == 5){ // Weight Shipping
        $allRules['settings.mode'] = 'required|string';
        $allRules['settings.merchant_id'] = 'required|string';
        $allRules['settings.public_key'] = 'required|string';
        $allRules['settings.private_key'] = 'required|string';
      }

      // Single Language Rules
      $allRules['is_active'] = 'required';
      $allRules['is_default'] = 'required';
      $allRules['image_id'] = 'required|exists:media,id';
      return $allRules;
    }
}
