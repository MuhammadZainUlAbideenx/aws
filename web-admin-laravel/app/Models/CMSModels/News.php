<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Admin;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $fillable = ['name','image_id','admin_id','is_active','news_category_id','slug','description','is_featured'];
    protected $table= 'newses';
    public function scopeWithAll($query)
    {
     return $query->with('image')->with('news_category')->with('user');
   }
    public function image()
    {
        return $this->belongsTo(Media::class,'image_id')->withAll();
    }
    public function user()
    {
        return $this->belongsTo(Admin::class,'admin_id')->withAll();
    }
    public function news_category(){
        return $this->belongsTo(NewsCategory::class,'news_category_id');
      }

}
