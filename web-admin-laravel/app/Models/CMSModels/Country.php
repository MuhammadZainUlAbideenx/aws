<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\City;
use App\Models\CMSModels\State;
use App\Models\CMSModels\Zone;
use App\Models\CMSModels\Admin;
use App\Models\CMSModels\Address;
use App\Models\VendorStore;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['name','iso_code_2','iso_code_3','is_active'];

    public function cities(){
      return $this->hasMany(City::class,'country_id');
    }
    public function zones(){
      return $this->hasMany(Zone::class,'country_id');
    }
    public function states(){
      return $this->hasMany(State::class,'country_id');
    }
    public function admins(){
      return $this->hasMany(Admin::class,'country_id');
    }
    public function addresses(){
      return $this->hasMany(Address::class,'country_id');
    }
    public function vendor_stores(){
      return $this->hasMany(VendorStore::class,'country_id');
    }



}
