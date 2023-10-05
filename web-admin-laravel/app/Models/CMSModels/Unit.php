<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Unit extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','is_active'];
}
