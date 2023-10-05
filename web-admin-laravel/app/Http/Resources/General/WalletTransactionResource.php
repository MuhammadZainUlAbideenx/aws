<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $current_currency = session('current_currency');
        return [
            'id' => $this->id,
            'wallet_id' => $this->wallet_id,
            'transaction_id' => $this->transaction_id,
            'transaction_type' => $this->transaction_type,
            'cash_in' =>  $this->cash_in ? attachCurrencyDecimal($this->cash_in) : null,
            'cash_out' => $this->cash_out ? attachCurrencyDecimal($this->cash_out) : null,
            'opening_balance' =>  attachCurrencyDecimal($this->opening_balance) ,
            'closing_balance' =>  attachCurrencyDecimal($this->closing_balance),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
