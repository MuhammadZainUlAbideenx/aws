<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    use HasTranslations;
    use HasFactory;
    public $translatable = ['description','display_name'];
    protected $fillable = ['name','description','display_name'];
}
