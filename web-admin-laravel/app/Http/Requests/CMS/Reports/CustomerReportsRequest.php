<?php

namespace App\Http\Requests\CMS\Reports;

use App\Http\Requests\WebRequest;


class CustomerReportsRequest extends WebRequest
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
      $allAttributes['rating'] = trans('messages.fields.rating');
      $allAttributes['description'] = trans('messages.fields.order');
      $allAttributes['product_id'] = trans('messages.fields.product');
      $allAttributes['customer_id'] = trans('messages.fields.customer');
      $allAttributes['order_status_id'] = trans('messages.fields.order_status_id');
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
        return [
            'date_from' => 'required_with:date_to|date',
            'date_to' => 'required_with:date_from|date',
        ];
    }
}
