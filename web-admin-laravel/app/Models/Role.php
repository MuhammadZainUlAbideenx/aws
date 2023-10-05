<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Admin;
use Spatie\Translatable\HasTranslations;

class Role extends LaratrustRole
{
    public $guarded = [];

    use HasTranslations;
    use HasFactory;
    public $translatable = ['description'];
    protected $fillable = ['description','display_name','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('admin');
   }
    public function admin()
    {
        return $this->hasOne(Admin::class , 'role_id');
    }
}
