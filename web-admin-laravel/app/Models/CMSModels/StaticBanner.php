<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class StaticBanner extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['image','name','description'];
    protected $fillable = ['image','expiry_date','url_type','type','is_active','name','description','website_url'];


}
