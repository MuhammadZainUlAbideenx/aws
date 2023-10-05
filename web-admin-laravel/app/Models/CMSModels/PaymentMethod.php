<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use Spatie\Translatable\HasTranslations;
use App\Models\CMSModels\PaymentMethodSetting;
use App\Models\CMSModels\Order;



class PaymentMethod extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','image_id','is_active','is_default'];

    public function settings(){
      return $this->hasMany(PaymentMethodSetting::class,'payment_method_id');
    }
    public function scopeWithAll($query)
    {
     return $query->with('image')->with('orders');
    }
    public function image()
    {
        return $this->belongsTo(Media::class,'image_id')->withAll();
    }
    public function orders(){
      return $this->hasMany(Order::class,'payment_method_id')->withAll();
    }
}
