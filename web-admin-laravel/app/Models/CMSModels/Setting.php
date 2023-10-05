<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  use HasFactory;
  protected $fillable = ['name','value'];
}
