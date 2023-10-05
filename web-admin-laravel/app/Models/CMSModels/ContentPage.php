<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\SeoPage;

use Spatie\Translatable\HasTranslations;

class ContentPage extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $fillable = ['name','is_active','description','slug'];
    public function scopeWithAll($query)
    {
     return $query->with('seo');
   }
    public function seo(){
      return $this->hasOne(SeoPage::class);
    }

}
