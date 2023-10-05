<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Vendor;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Admin;

class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use HasFactory, HasApiTokens, Notifiable;

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function addresses()
    {
        return $this->hasMany(Admin::class);
    }
    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
