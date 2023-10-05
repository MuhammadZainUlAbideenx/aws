<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class NewsCategory extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $fillable = ['name','image_id','is_active','slug','description'];
    public function scopeWithAll($query)
    {
     return $query->with('image');
   }
    public function image()
    {
        return $this->belongsTo(Media::class,'image_id');
    }

}
