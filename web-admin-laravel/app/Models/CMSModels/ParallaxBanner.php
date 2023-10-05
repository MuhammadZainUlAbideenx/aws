<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class ParallaxBanner extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['image','name','description','button_text'];
    protected $fillable = ['image','url_type','expiry_date','is_active','name','description','website_url','button_text'];


}
