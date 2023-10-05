<?php

namespace App\Http\Requests\Vendor\Riders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRiderCommissionRequest extends FormRequest
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
      $allAttributes['commission_type'] = trans('messages.fields.commission_type');
      $allAttributes['rate'] = trans('messages.fields.rate');

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
          'commission_type' => 'required|string',
          'rate' => 'required|string',
        ];
    }
}
