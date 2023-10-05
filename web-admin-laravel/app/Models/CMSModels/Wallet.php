<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = ['user_type', 'reference_table_id',  'balance'];

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id');
    }

}
