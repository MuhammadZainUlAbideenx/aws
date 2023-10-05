<?php

namespace App\Http\Requests\Mobile\ValidateCouponCodeRequest;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCouponCodeRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'coupon_code' => 'required|string',
          'order_amount' => 'required'
        ];
    }
}
