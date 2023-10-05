<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\City;
use App\Models\Vendor;
use App\Models\CMSModels\Media;
use Spatie\Translatable\HasTranslations;

class VendorStore extends Authenticatable implements MustVerifyEmail
{
  use HasTranslations;
  use HasFactory, HasApiTokens, Notifiable;
  public $translatable = ['description'];
  protected $fillable = ['name','vendor_id','cover_image_id','logo_image_id','description','address','city_id','country_id','state_id','phone','postal_code','slug','headline','is_active','latitude','longitude'];
  public function scopeWithAll($query)
  {
      return $query->with('vendor')
                    ->with('country')
                    ->with('state')
                    ->with('city')
                    ->with('cover_image')
                    ->with('store_logo');
  }
  public function vendor(){
    return $this->belongsTo(Vendor::class,'vendor_id');
  }
  public function country(){
    return $this->belongsTo(Country::class,'country_id');
  }
  public function state(){
    return $this->belongsTo(State::class,'state_id');
  }
  public function city(){
    return $this->belongsTo(City::class,'city_id');
  }
  public function cover_image(){
    return $this->belongsTo(Media::class,'cover_image_id')->withAll();
  }
  public function store_logo(){
    return $this->belongsTo(Media::class,'logo_image_id')->withAll();
  }
}
