<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductVariantDetails extends Model
{
    use HasFactory;
    protected $fillable = ['order_product_id','attribute_name','value_name'];

}
