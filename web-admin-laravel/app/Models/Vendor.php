<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Coupon;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Category;
use App\Models\CMSModels\PayoutRequest;
use Spatie\Translatable\HasTranslations;

class Vendor extends Authenticatable implements MustVerifyEmail
{
  use HasTranslations;
  use HasFactory, HasApiTokens, Notifiable;
  public $translatable = ['description'];
  protected $fillable = ['name','role_id','email','password','dob','profile_image_id','profile_image_path','slug','contact_phone','google_id','facebook_id','is_active','is_featured'];
  public function scopeWithAll($query)
  {
      return $query
              ->with('products')
              ->with('role')->with('profile_image')->with('coupons')->with('categories')->with('store')->with('followers');
  }
  public function products(){
    return $this->hasMany(Product::class,'vendor_id')->withAll()->with('attributes')->with('reviews')->with('variants');
  }
  public function store(){
    return $this->hasOne(VendorStore::class,'vendor_id')->withAll();
  }
  public function coupons(){
    return $this->hasMany(Coupon::class,'vendor_id');
  }
  public function riders(){
    return $this->hasMany(Rider::class,'vendor_id');
  }
  public function categories(){
    return $this->belongsToMany(Category::class,'vendor_category');
  }
  public function getCategoryIdsAttribute()
  {
      return $this->categories->pluck('id');
  }
  public function role(){
    return $this->belongsTo(Role::class,'role_id');
  }
  public function rider_shipping(){
    return $this->belongsTo(RiderShipping::class,'vendor_id');
  }
  public function profile_image(){
    return $this->belongsTo(Media::class,'profile_image_id')->withAll();
  }
  public function followers(){
    return $this->hasMany(VendorFollower::class,'vendor_id');
  }
  public function payoutRequests(){
    return $this->hasMany(PayoutRequest::class,'vendor_id');
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
