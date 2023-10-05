<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\CMSModels\ShippingMethodSetting;
use App\Models\CMSModels\Order;


class ShippingMethod extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','is_active','is_default'];
    public function scopeWithAll($query)
    {
     return $query->with('orders');
    }
    public function settings(){
      return $this->hasMany(ShippingMethodSetting::class,'shipping_method_id');
    }

    public function orders(){
      return $this->hasMany(Order::class,'shipping_method_id')->withAll();
    }
}
