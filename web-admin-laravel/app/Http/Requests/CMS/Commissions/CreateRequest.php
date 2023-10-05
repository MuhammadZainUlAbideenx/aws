<?php

namespace App\Http\Requests\CMS\Commissions;

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
      $allAttributes['vendor_commission_type'] = trans('messages.fields.vendor_commission_type');
      $allAttributes['commission_by_sale'] = trans('messages.fields.from_sale');
      $allAttributes['commission_rate'] = trans('messages.fields.commission_rate');
      $allAttributes['commission_by_category.*.rate'] = trans('messages.fields.commission_rate');
      $allAttributes['commission_by_sale.*.from_sale'] = trans('messages.fields.from_sale');
      $allAttributes['commission_by_sale.*.to_sale'] = trans('messages.fields.to_sale');
      $allAttributes['commission_by_sale.*.rate'] = trans('messages.fields.commission_rate');
      $allAttributes['commission_by_sale.*.rate_type'] = trans('messages.fields.commission_rate_type');
      $allAttributes['is_multi_vendor'] = trans('messages.fields.is_multi_vendor');
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
      if($allSettings['is_multi_vendor'] == 1){
        if($allSettings['vendor_commission_type'] == 0){
        return [
          'commission_by_category.*.category_id' => 'required|exists:categories,id',
          'commission_by_category.*.rate' => 'required|regex:/^[0-99.99]+$/',
          'commission_by_category.*.rate_type' => 'required_unless:commission_by_category.*.rate,0',
        //   'commission_by_category.*.commission_min_amount_fixed' => 'required_if:commission_by_category.*.rate_type,2',
        ];
      }else{
        return [
          'commission_by_sale.*.from_sale' => 'required|numeric',
          'commission_by_sale.*.to_sale' => 'required|numeric',
          'commission_by_sale.*.duration' => 'required|min:1|numeric',
          'commission_by_sale.*.rate' => 'required|regex:/^[0-99.99]+$/',
          'commission_by_sale.*.rate_type' => 'required',
        ];
      }
    }else{
      return [
        'is_multi_vendor' => 'required',
      ];
    }
  }
}
