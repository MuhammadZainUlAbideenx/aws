<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\SeoPage;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','slug','parent_id','icon_id','image_id','is_default','is_featured','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('image')->with('icon')->with('parent')->with('seo')->with('childrens');
   }
    public function seo(){
      return $this->hasOne(SeoPage::class);
    }
    public function image()
    {
        return $this->belongsTo(Media::class,'image_id')->withAll();
    }
    public function icon()
    {
        return $this->belongsTo(Media::class,'icon_id')->withAll();
    }
    public function products(){
      return $this->belongsToMany(Product::class,'product_category')->withAll();
    }

    public function parent()
   {
       return $this->belongsTo(Category::class, 'parent_id')->with('image')->with('icon');
   }

   public function children()
   {
       return $this->hasMany(Category::class, 'parent_id');
   }

   public function childrens()
  {
     return $this->children()->withAll();
  }
  public function commission()
  {
    return $this->hasOne(CommissionCategory::class, 'category_id');
  }
}
