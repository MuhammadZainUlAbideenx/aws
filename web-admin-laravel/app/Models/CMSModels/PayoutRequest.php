<?php

namespace App\Models\CMSModels;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable = ['vendor_id','rider_id', 'amount',  'note', 'status'];
    public function vendor(){
        return $this->belongsTo(Vendor::class);
      }

      public function rider(){
        return $this->belongsTo(Rider::class);
      }
}

