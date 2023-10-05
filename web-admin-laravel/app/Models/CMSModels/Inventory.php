<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Inventory extends Model
{

    protected $fillable = ['product_id','stock','purchase_price','refrence_number','stock_type'];

    public function scopeWithAll($query)
    {
     return $query->with('product');
   }
    public function product(){
      return $this->belongsTo(Product::class,'product_id');
    }
}
