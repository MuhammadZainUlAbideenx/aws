<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class SliderImage extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['image','name','heading','button_text'];
    protected $fillable = ['image','slider_type','url_type','expiry_date','is_active','name','website_url','discount','heading','button_text'];


}
