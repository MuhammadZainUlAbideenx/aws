<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Category;

class CommissionCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','rate','rate_type','commission_min_amount_fixed'];
    public function scopeWithAll($query)
    {
     return $query->with('category');
   }
    public function category()
    {
      return $this->belongsTo(Category::class,'category_id');
    }

}
