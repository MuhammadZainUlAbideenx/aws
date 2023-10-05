<?php

namespace App\Http\Requests\Vendor\VendorsStore;

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
        $allAttributes['store_details.description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
      }

      // Single Lang Attribute Names
      $allAttributes['store_details.name'] = trans('messages.fields.name');
      $allAttributes['store_details.headline'] = trans('messages.fields.headline');
      $allAttributes['store_details.phone'] = trans('messages.fields.contact_phone');
      $allAttributes['store_details.country_id'] = trans('messages.fields.country');
      $allAttributes['store_details.state_id'] = trans('messages.fields.state_id');
      $allAttributes['store_details.city_id'] = trans('messages.fields.city');
      $allAttributes['store_details.address'] = trans('messages.fields.address');
      $allAttributes['store_details.postal_code'] = trans('messages.fields.postal_code');
      $allAttributes['logo_image_id'] = trans('messages.fields.logo_image');
      $allAttributes['cover_image_id'] = trans('messages.fields.cover_image');

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
            $allRules['store_details.description.'.$language->code] = 'required|string';

          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['store_details.description.'.$language->code] = 'required|string';

          }
        }
      }
      // Single Language Rules
      $allRules['logo_image_id'] = 'required|exists:media,id';
      $allRules['cover_image_id'] = 'required|exists:media,id';
      // $allRules['profile_image_id'] = 'required_if:is_credentials,1|exists:media,id';
      $allRules['store_details.name'] = 'required|string|min:3|max:18';
      $allRules['store_details.headline'] = 'required|string|min:3|max:18';
      $allRules['store_details.phone'] = 'required|string|min:3|max:18';
      $allRules['store_details.country_id'] = 'required|exists:countries,id';
      $allRules['store_details.state_id'] = 'required|exists:states,id';
      $allRules['store_details.city_id'] = 'required|exists:cities,id';
      $allRules['store_details.address'] = 'required|max:255';
      $allRules['store_details.postal_code'] = 'required|number|max:18';
      // $allRules['categories'] = 'required|exists:categories,id';
      return $allRules;
    }
}
