<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\CMSModels\Address;
use App\Models\CMSModels\Review;
use App\Models\CMSModels\Message;


class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $guard = 'customer';
    protected $fillable = ['email','password','first_name','last_name','gender','dob','phone','google_id','facebook_id','profile_image_path','is_active'];

    public function scopeWithAll($query)
    {
     return $query->with('addresses')->with('wishlistProducts');
   }
    public function addresses(){
      return $this->hasMany(Address::class,'customer_id')->withAll();
    }
    public function cartItems(){
      return $this->hasMany(Cart::class,'customer_id')->withAll();
    }
    public function reviews(){
      return $this->hasMany(Review::class,'customer_id');
    }
    public function wishlistProducts()
    {
      return $this->belongsToMany(Product::class, 'wishlist_products','customer_id','product_id')->with('reviews')->withAll();

    }
    public function orders(){
        return $this->hasMany(Order::class,'customer_id');
      }
      public function messages()
      {
          return $this->hasMany(Message::class);
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
}
