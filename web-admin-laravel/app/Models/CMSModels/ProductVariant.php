<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\OrderStatus;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['price','product_id','variant','sku','stock','name_combination'];
    public function scopeWithAll($query)
    {
     return $query->with('product');
   }
    public function product(){
      return $this->belongsTo(Product::class,'product_id')->withAll();
    }
}
