<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\Zone;
use App\Models\CMSModels\City;
use App\Models\CMSModels\Admin;
use App\Models\VendorStore;

class State extends Model
{
    use HasFactory;
    protected $fillable = ['name','country_id','zone_id','code','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('countries')->with('zone');
   }
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function cities()
    {
        return $this->hasMany(City::class,'state_id');
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id');
    }
    public function amdins(){
      return $this->hasMany(Admin::class,'state_id');
    }
    public function addresses(){
      return $this->hasMany(Address::class,'state_id');
    }
    public function vendor_stores(){
      return $this->hasMany(VendorStore::class,'state_id');
    }

}
