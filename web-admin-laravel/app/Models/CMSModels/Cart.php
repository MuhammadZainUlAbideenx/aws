<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['session_token','customer_id','product_id','quantity','variant','is_ordered'];
    public function scopeWithAll($query)
    {
     return $query->with('product')->with('attribute_value_names');
    }
    public function product(){
      return $this->belongsTo(Product::class,'product_id')->withAll()->with('reviews');
    }
    public function attribute_value_names(){
        return $this->hasMany(CartAttributeValueName::class,'cart_id');
    }
    public function variants(){
        return $this->hasMany(ProductVariant::class,'variant','variant');
    }
}
