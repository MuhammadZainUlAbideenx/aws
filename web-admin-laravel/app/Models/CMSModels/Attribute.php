<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = ['name','description','is_active'];
    public $translatable = ['name','description'];
    public function scopeWithAll($query)
    {
     return $query->with('values');
   }
    public function values(){
      return $this->hasMany(ProductAttributeValue::class,'attribute_id');
    }
    public function products(){
      return $this->belongsToMany(Product::class,'product_attribute');
    }
}
