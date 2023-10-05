<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Vendor;

class Coupon extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['description'];
    protected $fillable = ['code','description','is_active','discount_type',
                        'free_shipping','minimum_spend','maximum_spend','individual_use',
                        'amount','exclude_sale_items','products','exclude_products','categories',
                        'exclude_categories','email_restrictions','usage_limit','user_limit','expiry_date','vendor_id','is_featured'];
    public function scopeWithAll($query)
    {
        return $query->with('products')->with('vendor')->with('categories')->with('email_restrictions');
    }
    public function products(){
      return $this->belongsToMany(Product::class,'coupon_product');
    }
    public function vendor(){
      return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function categories(){
      return $this->belongsToMany(Category::class,'coupon_category');
    }
    public function email_restrictions(){
      return $this->belongsToMany(Customer::class,'coupon_customer');
    }
}
