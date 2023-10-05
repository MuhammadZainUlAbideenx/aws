<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        $transactions = $this->whenLoaded('transactions');
        $total_deposit = 0;
        $total_withdraw = 0;
        $total_refund = 0;
        if($transactions && count($transactions) > 0){
            $total_deposit = $transactions->where('transaction_type','deposit')->sum('cash_in');
            $total_withdraw = $transactions->where('transaction_type','withdraw')->sum('cash_out');
            $total_refund = $transactions->where('transaction_type','refund')->sum('cash_in');
        }
        $current_currency = session('current_currency');
        return [
            'id' => $this->id,
            'user_type' => $this->user_type,
            'reference_table_id' => $this->reference_table_id,
            'balance' => $this->balance ?  attachCurrencyDecimal($this->balance) : 0,
            'total_deposit' => $total_deposit ?  attachCurrencyDecimal($total_deposit) : 0,
            'total_withdraw' => $total_withdraw ?  attachCurrencyDecimal($total_withdraw) : 0,
            'total_refund' => $total_refund ?  attachCurrencyDecimal($total_refund): 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
