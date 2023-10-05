<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\ReviewStatus;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['review_status_id','product_id','customer_id','description','order_id','rating','is_active','images_url'];
    public function scopeWithAll($query)
    {
     return $query->with('customer')->with('product')->with('review_status');
   }
   public function scopeWithAllVendor($query)
   {
    return $query->with('customer')->whereHas('product',function($q){
        $q->where('vendor_id',auth()->user()->id);
})->with('product')->with('review_status');
  }
    public function customer(){
      return $this->belongsTo(Customer::class,'customer_id');
    }
    public function product(){
      return $this->belongsTo(Product::class,'product_id')->with('media');
    }
    public function review_status(){
      return $this->belongsTo(ReviewStatus::class,'review_status_id');
    }

}
