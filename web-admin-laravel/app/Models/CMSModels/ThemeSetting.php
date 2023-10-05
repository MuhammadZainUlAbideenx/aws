<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
  use HasFactory;
  protected $fillable = ['name','value','header_is_default','footer_is_default'];
}
