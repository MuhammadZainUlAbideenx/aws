<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Role;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\News;
use App\Models\CMSModels\City;


class Admin extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, HasApiTokens, Notifiable;
    protected $guard = 'admin';
    protected $fillable = ['email','password','address','role_id','country_id','state_id','city_id','zip_code','first_name','last_name','gender','dob','profile_image_path','phone','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('role')->with('country')->with('state')->with('city');
   }
   public function newses(){
     return $this->hasMany(News::class,'admin_id');
   }
   public function faqs(){
    return $this->hasMany(Faq::class,'admin_id');
   }
    public function role(){
      return $this->belongsTo(Role::class,'role_id');
    }
    public function country(){
      return $this->belongsTo(Country::class,'country_id');
    }
    public function state(){
      return $this->belongsTo(State::class,'state_id');
    }
    public function City(){
      return $this->belongsTo(City::class,'city_id');
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
