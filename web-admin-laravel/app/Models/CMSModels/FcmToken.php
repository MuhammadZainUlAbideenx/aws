<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    use HasFactory;
    protected $fillable = ['user_type','user_id','device_key','device_id'];
    public $timestamps = false;
}
