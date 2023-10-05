<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Customer;
use App\Models\Rider;
use App\Models\Vendor;

class Message extends Model
{
    protected $fillable = ['message', 'sender_id', 'receiver_id', 'user_type','order_number'];
    public function customer()
    {
        return $this->belongsTo(Customer::class,'sender_id','id');
    }
    public function rider()
    {
        return $this->belongsTo(Rider::class,'sender_id','id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'receiver_id','id');
    }

}
