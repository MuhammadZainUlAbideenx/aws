<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\City;


class Address extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','country_id','state_id','city_id','address','near_by','zip_code','is_default','phone','latitude','longitude'];
    public function scopeWithAll($query)
    {
     return $query->with('customer')->with('country')->with('state')->with('city');
   }
    public function customer(){
      return $this->belongsTo(Customer::class,'customer_id');
    }
    public function country(){
      return $this->belongsTo(Country::class,'country_id');
    }
    public function state(){
      return $this->belongsTo(State::class,'state_id')->withAll();
    }
    public function city(){
      return $this->belongsTo(City::class,'city_id')->withAll();
    }
}
