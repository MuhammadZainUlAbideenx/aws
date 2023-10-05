<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductAttributeValue extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = ['product_id','attribute_id','slug','name','description','is_active'];
    public $translatable = ['name','description'];
    public function scopeWithAll($query)
    {
     return $query->with('attribute');
   }
   public function attribute(){
     return $this->belongsTo(Attribute::class,'attribute_id');
   }
   public function product(){
     return $this->belongsTo(Product::class,'product_id');
   }
}
