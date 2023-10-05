<?php

namespace App\Http\Requests\General;
use App\Http\Requests\WebRequest;


class WalletPaymentRequest extends WebRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_method_code' => 'required',
            'cardInfo.number' => 'required_if:payment_method_code,stripe,braintree|nullable|min:16|max:16',
            'cardInfo.exp_month' => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:2',
            'cardInfo.exp_year' => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:4',
            'cardInfo.cvc' => 'required_if:payment_method_code,stripe,braintree|nullable|min:3|max:3',
        ];
    }

}
