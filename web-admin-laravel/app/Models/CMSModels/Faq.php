<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Admin;
use App\Models\CMSModels\Product;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['question','answer'];
    protected $fillable = ['question','admin_id','is_active','product_id','answer'];
    public function scopeWithAll($query)
    {
     return $query->with('user')->with('product');
   }
    public function user()
    {
        return $this->belongsTo(Admin::class,'admin_id')->withAll();
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->with('media');
    }


}
