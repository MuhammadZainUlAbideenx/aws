<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Category;
use App\Models\CMSModels\FlashSale;
use App\Models\CMSModels\SpecialSale;
use App\Models\CMSModels\SeoPage;
use App\Models\CMSModels\Currency;
use App\Models\CMSModels\Manufacturer;
use App\Models\CMSModels\TaxClass;
use App\Models\CMSModels\Unit;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Review;
use App\Models\CMSModels\Brand;
use App\Models\Vendor;
use Illuminate\Support\Facades\Cache;

use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name', 'description', 'short_description', 'refund_policy'];
    protected $fillable = [
        'vendor_id', 'name', 'description', 'short_description', 'refund_policy', 'sku', 'product_type', 'modal', 'price', 'stock', 'quantity', 'available_date', 'weight', 'unit_id',
        'is_active', 'is_feature', 'brand_id', 'manufacturer_id', 'tax_class_id', 'product_ordered', 'product_liked', 'slug', 'external_link', 'max_order', 'min_order', 'shipping_weight'
    ];
    public function scopeWithAllDetail($query)
    {
        return $query->with('categories')
        ->with('vendor')
          ->with('tax_class')
        ->with('unit')
        ->with('attributes')
        ->with('variants')
        ->with('brand')
        ->with('seo');

    }
    public function scopeWithDetailWeb($query)
    {

        return $query->with('categories')
            ->with('vendor')
            ->with('tax_class')
            ->with('unit')
            ->with('attributes')
            ->with('variants')
            ->with('brand')
            ->with('related_products')
            ->with('wishlist_products')
            ->with('reviews')
            ->with('faqs',function($q)
            {
                $q->where('is_active',1);
            })
            ->with('seo');
    }
    public function scopeWithAll($query)
    {
      $value =  $this->showOutOfStockItems();
        if ($value) {
            return $query->with('manufacturer')->with('media')->with('flash_sale')
            ->with('special_sale');
        }
        else
        {
            return $query->with('manufacturer')->with('media')->with('flash_sale')
            ->with('special_sale')->where('stock','>', 0);
        }

    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id')->with('values');
    }
    public function product_attribute_values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category')->withAll();
    }
    public function categoriesWithOutAll()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
    public function getConvertedPriceAttribute()
    {
        $price = get_converted_price($this->price);
        return $price;
    }
    public function getDisplayPriceAttribute()
    {
        $price = get_display_price($this->price);
        return $price;
    }
    public function getDefaultPriceAttribute()
    {
        $price = get_price($this->price);
        return $price;
    }
    public function getCurrentCurrencyAttribute()
    {
        $current_currency_code = get_current_currency_code();
        return $current_currency_code;
    }
    public function getDefaultCurrencyAttribute()
    {
        $default_currency_code = get_default_currency_code();
        return $default_currency_code;
    }
    public function getCurrencyConversionRateAttribute()
    {
        $current_currency_conversion_rate = get_currency_conversion_rate();
        return $current_currency_conversion_rate;
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'product_media')->withAll()->with('small_thumbnail')->withPivot(['sort_order', 'description', 'alt_text']);
    }
    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id');
    }
    public function seo()
    {
        return $this->hasOne(SeoPage::class);
    }
    public function flash_sale()
    {
        return $this->hasOne(FlashSale::class);
    }
    public function special_sale()
    {
        return $this->hasOne(SpecialSale::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class)->withAll();
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class)->withAll();
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function tax_class()
    {
        return $this->belongsTo(TaxClass::class);
    }
    // copy vendor function.... comment the previous function and update new function
    // public function vendor(){
    //   return $this->belongsTo(Vendor::class)->with('profile_image')->with('coupons')->with('categories')->with('store');
    // }
    // updated  vendor  function
    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->with('store');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->with('customer')->with('review_status');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }
    public function related_products()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id')->with('reviews')->with('media');
    }
    public function related_products_without_all()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
    }
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'product_id');
    }
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
    public function wishlist_products()
    {
        return $this->hasMany(WishlistProduct::class, 'product_id');
    }
    public function showOutOfStockItems()
    {
        $settings = Cache::get("general_settings");
        $show_out_of_stock_products_value = (int)$settings['show_out_of_stock_products'];
        return $show_out_of_stock_products_value;

    }
}
