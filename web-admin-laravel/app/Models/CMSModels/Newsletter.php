<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Newsletter extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['email','is_active','is_verified','verified_at'];


}
