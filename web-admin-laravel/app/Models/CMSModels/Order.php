<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Rider;
use App\Models\CMSModels\Coupon;
use App\Models\CMSModels\OrderStatus;
use App\Models\CMSModels\OrderProduct;
use App\Models\CMSModels\BillingAddress;
use App\Models\CMSModels\ShippingAddress;
use App\Models\CMSModels\ShippingMethod;
use App\Models\CMSModels\PaymentMethod;
use App\Models\Vendor;



class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_status_id', 'order_status_reason', 'default_currency_total', 'transaction_status', 'parent_order_id', 'vendor_id', 'order_number', 'rider_id', 'transaction_id', 'payment_method_id', 'shipping_method_id', 'total', 'sub_total', 'shipping_price', 'customer_id', 'description', 'rating', 'is_paid', 'current_currency', 'current_currency_total', 'current_currency_value', 'current_currency_sub_total', 'current_currency_shipping_price', 'default_currency', 'default_currency_value', 'usd_currency_value', 'is_active', 'is_coupon_applied', 'coupon_code', 'coupon_amount', 'coupon_id','commission_type', 'commission_amount'];
    public function scopeWithAll($query)
    {
        return $query
        ->with('order_status');
    }

    public function scopeWithReportDetail($query)
    {
        return $query
        ->with('customer')
        ->with('coupon');
    }

    public function scopeWithAllDetail($query)
    {
        return $query
        ->with('customer')
        ->with('rider')
        ->with('order_products')
        ->with('vendor_order_products')
        ->with('order_addresses')
        ->with('payment_method')
        ->with('coupon')
        ->with('vendor_order_addresses')
        ->with('vendor',function($q){
            $q->with('store')->with('followers');})
            ;
    }

    public function scopeWithAllVendor($query)
    {
        return $query->with('customer')->with('rider')->with('vendor_order_products',function($query){
            $query->whereHas('product',function($q){
                $q->where('vendor_id',auth()->user()->id);
            });
        })->with('order_products')->with('order_status')->with('vendor_order_addresses')->with('payment_method')->with('coupon')->with('order_addresses')->with('vendor',function($q){
            $q->with('store')->with('followers');
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'status_code');
    }
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id')->withAll();
    }

    public function vendor_order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'parent_order_id')->withAll();
    }
    public function order_addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id')->withAll();
    }
    public function vendor_order_addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id' ,'parent_order_id')->withAll();
    }
    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_address_id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
