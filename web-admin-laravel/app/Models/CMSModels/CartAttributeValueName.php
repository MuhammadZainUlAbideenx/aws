<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAttributeValueName extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id','attribute_name','value_name'];

}
