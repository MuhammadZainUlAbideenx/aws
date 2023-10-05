<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\PaymentMethod;


class PaymentMethodSetting extends Model
{
  use HasFactory;
  protected $fillable = ['name','value','payment_method_id'];


  public function payment_method(){
    return $this->belongsTo(PaymentMethod::class,'payment_method_id');
  }
}
