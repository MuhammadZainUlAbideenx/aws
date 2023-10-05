<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\City;
use App\Models\CMSModels\Order;


class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','first_name','email','last_name','country_id','state_id','city_id','near_by','address','zip_code','phone','address_type','latitude','longitude'];
    public function scopeWithAll($query)
    {
     return $query->with('order')->with('country')->with('state')->with('city');
   }
//    public function scopeWithAllVendor($query)
//     {
//      return $query->with('vendorOrder')->with('country')->with('state')->with('city');
//    }
    public function country(){
      return $this->belongsTo(Country::class,'country_id');
    }
    public function state(){
      return $this->belongsTo(State::class,'state_id');
    }
    public function city(){
      return $this->belongsTo(City::class,'city_id');
    }
    public function order(){
      return $this->belongsTo(Order::class,'order_id');
    }

}
