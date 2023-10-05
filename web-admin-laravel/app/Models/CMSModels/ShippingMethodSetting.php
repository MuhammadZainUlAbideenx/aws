<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\ShippingMethod;


class ShippingMethodSetting extends Model
{
  use HasFactory;
  protected $fillable = ['name','value','shipping_method_id'];


  public function shipping_method(){
    return $this->belongsTo(ShippingMethod::class,'shipping_method_id');
  }
}
