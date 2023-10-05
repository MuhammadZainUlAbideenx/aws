<?php

namespace App\Http\Requests\CMS\Orders;

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
          'description' => 'required|string|max:255',
          'rating' => 'required|numeric|gt:0|max:5.0',
          'product_id' => 'required|exists:products,id',
          'order_status_id' => 'required|exists:order_statuses,id',
          'customer_id' => 'required|exists:customers,id',
          'is_active' => 'required|bool',
        ];
    }
}
