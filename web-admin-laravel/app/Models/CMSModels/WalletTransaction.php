<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
      protected $fillable = ['wallet_id','transaction_id','transaction_type','order_number','cash_in','cash_out','opening_balance','closing_balance','description'];

      public function wallet()
      {
          return $this->belongsTo(wallet::class,'id');
      }
}

