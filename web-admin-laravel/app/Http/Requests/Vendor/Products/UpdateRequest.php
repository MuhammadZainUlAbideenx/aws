<?php

namespace App\Http\Requests\Vendor\Products;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateRequest extends FormRequest
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
        $allAttributes['short_description.'.$language->code] = $language->name.' '.trans('messages.fields.short_description');
        $allAttributes['description.'.$language->code] = $language->name.' '.trans('messages.fields.description');
        $allAttributes['refund_policy.'.$language->code] = $language->name.' '.trans('messages.fields.refund_policy');
      }

      // Single Lang Attribute Names
      $allAttributes['vendor_id'] = trans('messages.fields.vendor');
      $allAttributes['weight'] = trans('messages.fields.weight');
      $allAttributes['sku'] = trans('messages.fields.sku');
      $allAttributes['unit_id'] = trans('messages.fields.weight_unit');
      $allAttributes['price'] = trans('messages.fields.price');
      $allAttributes['price'] = trans('messages.fields.price');
      $allAttributes['categories'] = trans('messages.fields.categories');
      $allAttributes['modal'] = trans('messages.fields.modal');
      $allAttributes['manufacturer_id'] = trans('messages.fields.manufacturer');
      $allAttributes['brand_id'] = trans('messages.fields.brand');
      $allAttributes['tax_class_id'] = trans('messages.fields.tax_class');
      $allAttributes['shipping_weight'] = trans('messages.fields.shipping_weight');
      $allAttributes['min_order'] = trans('messages.fields.min_order');
      $allAttributes['max_order'] = trans('messages.fields.max_order');
      $allAttributes['is_active'] = trans('messages.fields.status');
      $allAttributes['product_type'] = trans('messages.fields.product_type');
      $allAttributes['available_date'] = trans('messages.fields.available_date');
      $allAttributes['flash_sale.start_date'] = trans('messages.fields.flash_sale_start_date');
      $allAttributes['flash_sale.expire_date'] = trans('messages.fields.flash_sale_expire_date');
      $allAttributes['flash_sale.product_price'] = trans('messages.fields.flash_sale_product_price');
      $allAttributes['special_sale.expire_date'] = trans('messages.fields.special_sale_expire_date');
      $allAttributes['special_sale.special_price'] = trans('messages.fields.special_sale_special_price');

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
      $allSettings = allSettings();
      $allRules = [];
      $allLanguages = allLanguages();
      $translationRequiredForAllLanguages = translationRequiredForAllLanguages();
      if($translationRequiredForAllLanguages == 1){
        foreach ($allLanguages as $language){
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['short_description.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';
          }
      }
      else{
        foreach ($allLanguages as $language){
          if($language->is_default){
            // $allRules['name.'.$language->code] = 'required|string|max:255|unique_translation:products,name,{$product->id}';
            $allRules['name.'.$language->code] = 'required|string';
            $allRules['short_description.'.$language->code] = 'required|string';
            $allRules['description.'.$language->code] = 'required|string';
          }
        }
      }
      // Single Language Rules
      $allRules['weight'] = 'required|numeric';
    //   $allRules['sku'] = '|unique:products,sku,'. $this->product->id;
    $allRules['sku'] = 'required_if:product_type,1';
      $allRules['unit_id'] = 'required|numeric|exists:units,id';
      $allRules['price'] = 'required|numeric';
      $allRules['stock'] = 'required|numeric';
      $allRules['categories'] = 'required|exists:categories,id';
      $allRules['modal'] = 'required|string';
      $allRules['manufacturer_id'] = 'required|exists:manufacturers,id';
      $allRules['brand_id'] = 'exists:brands,id|nullable';
      $allRules['tax_class_id'] = 'required|exists:tax_classes,id';
      $allRules['min_order'] = 'required|numeric|lt:max_order';
      $allRules['max_order'] = 'required|numeric';
      $allRules['is_active'] = 'required|boolean';
      $allRules['product_type'] = 'required';
      $allRules['available_date'] = 'required';
      $allRules['shipping_weight'] = 'required|integer';
      $allRules['flash_sale.exists'] = 'required|boolean';
      $allRules['flash_sale.start_date'] = 'required_if:flash_sale.exists,===,true';
      $allRules['flash_sale.expire_date'] = 'required_if:flash_sale.exists,===,true';
      if ($this->flash_sale['exists']) {
          $allRules['flash_sale.product_price'] = 'required_if:flash_sale.exists,===,true|lt:price';
      }
      // $allRules['flash_sale.description'] = 'required|string';
      $allRules['special_sale.exists'] = 'required|boolean';
      if ($this->special_sale['exists']) {
          $allRules['special_sale.special_price'] = 'special_sale.exists,===,true|lt:price';
      }
      $allRules['special_sale.expire_date'] = 'required_if:special_sale.exists,===,true';
      return $allRules;
    }
}
