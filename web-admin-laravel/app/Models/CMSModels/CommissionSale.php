<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;

class CommissionSale extends Model
{
    use HasFactory;
    protected $fillable = ['to_sale','from_sale','rate_type','duration','rate'];

}
