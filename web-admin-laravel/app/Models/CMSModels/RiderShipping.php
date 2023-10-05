<?php

namespace App\Models\CMSModels;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class RiderShipping extends Authenticatable implements MustVerifyEmail
{
  use HasFactory, HasApiTokens, Notifiable;
  protected $table = 'rider_shipping';
  protected $fillable = ['vendor_id','commission_type','commission_rate'];
  public function vendors(){
    return $this->hasMany(Vendor::class);
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
