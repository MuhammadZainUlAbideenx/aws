<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\Admin;
use App\Models\VendorStore;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name','state_id','country_id','code','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('countries')->with('state')->with('admins')->with('addresses');
   }
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class,'state_id');
    }
    public function admins()
    {
        return $this->hasMany(Admin::class,'city_id');
    }
    public function addresses(){
      return $this->hasMany(Address::class,'city_id');
    }
    public function vendor_stores(){
      return $this->hasMany(VendorStore::class,'city_id');
    }

}
