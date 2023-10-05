<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistProduct extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','product_id'];
    public function scopeWithAll($query)
    {
     return $query->with('product');
    }
    public function product(){
      return $this->belongsTo(Product::class,'product_id')->withAll();
    }
}
