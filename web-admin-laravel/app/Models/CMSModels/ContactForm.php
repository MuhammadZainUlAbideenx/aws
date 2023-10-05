<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\SeoPage;

use Spatie\Translatable\HasTranslations;

class ContactForm extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = [];
    protected $fillable = ['name','email','subject','message'];


}
