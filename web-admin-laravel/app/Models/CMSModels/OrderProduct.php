<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\OrderProductVariantDetails;


class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','vendor_id','quantity','product_id','variant','sale_type','sale_price_current','total_sale_price_current','sale_price_usd','total_sale_price_usd','single_price_current','total_price_current','single_price_default','total_price_default','single_price_usd','total_price_usd','commission_type','commission_rate_type','commission_rate','commission_amount'];
    public function scopeWithAll($query)
    {
     return $query->with('product')->with('order_product_variant_details');
   }
    // public function product(){
    //   return $this->belongsTo(Product::class,'product_id')->withAll();
    // }
    public function product(){
        return $this->belongsTo(Product::class,'product_id')->with('media')->with('reviews');
      }
    public function order(){
      return $this->belongsTo(Order::class,'order_id')->withAll();
    }
    public function order_product_variant_details(){
      return $this->hasMany(OrderProductVariantDetails::class,'order_product_id');
    }




}
