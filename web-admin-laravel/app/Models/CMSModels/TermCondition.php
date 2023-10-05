<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TermCondition extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['text'];
    protected $fillable = ['text'];

}
