<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\CMSModels\City;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Message;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\PayoutRequest;
use App\Models\CMSModels\State;
use Spatie\Translatable\HasTranslations;

class Rider extends Authenticatable implements MustVerifyEmail
{
  use HasTranslations;
  use HasFactory, HasApiTokens, Notifiable;
  public $translatable = ['description'];
  protected $fillable = ['first_name','last_name','role_id','vendor_id','user_id','email','gender','password','store_type','dob','profile_image_path','phone','is_active',"address",'country_id','city_id','state_id','zip_code','latitude','longitude'];
  public function scopeWithAll($query)
  {
      return $query
              ->with('role')->with('country')->with('state')->with('city')->with('orders');
  }
  public function orders(){
    return $this->hasMany(Order::class,'rider_id');
  }
  public function payoutRequests(){
    return $this->hasMany(PayoutRequest::class,'rider_id');
  }
//   public function messages(){
//     return $this->hasMany(Message::class,'sender_id');
//   }
  public function role(){
    return $this->belongsTo(Role::class,'role_id');
  }
  public function country(){
    return $this->belongsTo(Country::class,'country_id');
  }
  public function state(){
    return $this->belongsTo(State::class,'state_id');
  }
  public function vendor(){
    return $this->belongsTo(Vendor::class);
  }
  public function City(){
    return $this->belongsTo(City::class,'city_id');
  }
  public function image()
  {
      return $this->belongsTo(Media::class,'image_id');
  }
  protected $hidden = [
    'password',
    'remember_token',
];

/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    'email_verified_at' => 'datetime',
];
}
