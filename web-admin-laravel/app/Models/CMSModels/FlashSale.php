<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
class FlashSale extends Model
{
  use HasFactory;
  protected $fillable = ['product_price','start_date','expire_date','is_active'];
  public function scopeWithAll($query)
  {
   return $query->with('product');
 }
  public function product()
  {
      return $this->belongsTo(Product::class);
  }
  public function getConvertedPriceAttribute(){
    $price = get_converted_price($this->product_price);
    return $price;
  }
  public function getDisplayPriceAttribute(){
    $price = get_display_price($this->product_price);
    return $price;
  }
  public function getDefaultCurrencyPriceAttribute(){
    $price = get_price($this->product_price);
    return $price;
  }
  public function getCurrentCurrencyAttribute(){
    $current_currency_code = get_current_currency_code();
      return $current_currency_code;
  }
  public function getDefaultCurrencyAttribute(){
    $default_currency_code = get_default_currency_code();
      return $default_currency_code;
  }
  public function getCurrencyConversionRateAttribute(){
    $current_currency_conversion_rate = get_currency_conversion_rate();
      return $current_currency_conversion_rate;
  }
}
