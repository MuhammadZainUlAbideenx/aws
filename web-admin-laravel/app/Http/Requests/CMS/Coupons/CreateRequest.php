<?php

namespace App\Http\Requests\CMS\Coupons;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Http\Request;

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
      $allAttributes['code'] = trans('messages.fields.code');
      $allAttributes['vendor_id'] = trans('messages.fields.vendor');
      $allAttributes['discount_type'] = trans('messages.fields.discount_type');
      $allAttributes['amount'] = trans('messages.fields.amount');
      $allAttributes['expiry_date'] = trans('messages.fields.expiry_date');
      $allAttributes['minimum_spend'] = trans('messages.fields.minimum_spend');
      $allAttributes['maximum_spend'] = trans('messages.fields.maximum_spend');
      $allAttributes['products'] = trans('messages.fields.products');
      $allAttributes['categories'] = trans('messages.fields.categories');
      $allAttributes['email_restrictions'] = trans('messages.fields.email_restrictions');
      $allAttributes['usage_limit'] = trans('messages.fields.usage_limit');
      $allAttributes['user_limit'] = trans('messages.fields.user_limit');
      $allAttributes['free_shipping'] = trans('messages.fields.free_shipping');
      $allAttributes['individual_use'] = trans('messages.fields.individual_use');
      $allAttributes['exclude_sale_items'] = trans('messages.fields.exclude_sale_items');
      $allAttributes['is_active'] = trans('messages.fields.status');
      $allAttributes['not_in_range'] = trans('messages.fields.not_in_range');
      // Single Lang Attribute Names

      return $allAttributes;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
       $allSettings = allSettings();
      // multi language Rules
      $allRules = [];
      $allLanguages = allLanguages();
      $translationRequiredForAllLanguages = translationRequiredForAllLanguages();
      if($translationRequiredForAllLanguages == 1){
        foreach ($allLanguages as $language){
            $allRules['description.'.$language->code] = 'required|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['description.'.$language->code] = 'required|string';

          }
        }
      }
      $user = Auth::user();
      if($user->hasRole('admin') && (int)$allSettings['is_multi_vendor'] == 1){
        // $allRules['vendor_id'] = 'required|exists:vendors,id';
      }

      $not_in_range = 'nullable';
        if($request->discount_type == 2){
          if($request->amount > 99 || $request->amount < 1){
            $not_in_range = 'required';
          }
        }
        if($request->discount_type == 4){
            if($request->amount > 99 && $request->amount < 1){
              $not_in_range = 'required';
            }
          }
      // Single Language Rules
      $allRules['code'] = 'required|string|unique:coupons,code';
      $allRules['discount_type'] = 'required|numeric';
      $allRules['amount'] = 'required|numeric';
      $allRules['expiry_date'] = 'required';
      $allRules['minimum_spend'] = 'required|integer|min:1';
      $allRules['maximum_spend'] = 'required|integer|gt:minimum_spend';
      $allRules['products'] = 'nullable|exists:products,id';
      $allRules['categories'] = 'nullable|exists:categories,id';
      $allRules['email_restrictions'] = 'nullable|exists:customers,id';
      $allRules['usage_limit'] = 'required|numeric';
      $allRules['user_limit'] = 'required|numeric';
      $allRules['free_shipping'] = 'boolean';
      $allRules['individual_use'] = 'boolean';
      $allRules['exclude_sale_items'] = 'boolean';
      $allRules['is_active'] = 'required';
      $allRules['not_in_range'] = $not_in_range;
      return $allRules;
    }
}
