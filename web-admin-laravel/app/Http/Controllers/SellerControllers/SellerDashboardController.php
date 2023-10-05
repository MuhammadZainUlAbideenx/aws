<?php

namespace App\Http\Controllers\SellerControllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Vendor;
use App\Http\Resources\Vendor\OrdersResource;
use App\Http\Resources\Vendor\SalesOrdersResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\OrderProduct;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Review;
use App\Models\CMSModels\Sales;
use App\Models\Vendor as ModelsVendor;

class SellerDashboardController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
    }

    /********* FETCH ALL Admins ***********/
    public function index()
    {
        $vendor_product_orders = OrderProduct::whereHas('product', function ($q) {
            $q->where('vendor_id', auth()->user()->id);
        })->groupBy('order_id')->get();

        $order_ids = $vendor_product_orders->pluck('order_id')->toArray();
        array_push($order_ids, 0);
        $orders = Order::withAllVendor()->where('vendor_id', auth()->user()->id)->whereIn('parent_order_id', $order_ids)->get();
        $order_counts = count($orders);
        $customers = Order::whereIn('id', $order_ids)->groupBY('customer_id')->count();
        $products = Product::where('vendor_id', auth()->user()->id)->count();
        $sales =Order::where('vendor_id',auth()->user()->id)->sum('current_currency_sub_total');
        $sales_details =Order::where('vendor_id',auth()->user()->id)->get();
        $min_sale_amount = $sales_details->min('current_currency_sub_total');
        $max_sale_amount = $sales_details->max('current_currency_sub_total');
        $sales_details = SalesOrdersResource::collection($sales_details);
        $vendor = ModelsVendor::where('id', auth()->user()->id)->first();
        $vendor_products = $vendor->products ? $vendor->products:[];
        if ($vendor_products) {
            $product_ids = $vendor_products->pluck('id');
            $reviews = Review::whereIn('product_id', $product_ids)->get();
            if ($reviews->count() > 0) {
                $reviews_average_rating = $reviews->sum('rating') / $reviews->count();
            }
            else
            {
                $reviews_average_rating = null;
            }
        }
        $arr = [
            'orders' => $order_counts,
            'products' => $products,
            'customers' => $customers,
            'sales' => attachCurrencyDecimal($sales),
            'min_sale_amount'=> $min_sale_amount,
            'max_sale_amount'=> $max_sale_amount,
            'reviews_average_rating' => $reviews_average_rating,
            'sales_details' => $sales_details
        ];

        return response()->json($arr);
    }
    public function getVendorAndStoreStatus()
    {
        $vendor = ModelsVendor::where('id', auth()->user()->id)->first();
        $vendor_status = $vendor->is_active;
        $vendor_store_status = $vendor->store->is_active;
        return response(["vendor_status" => $vendor_status, "vendor_store_status" => $vendor_store_status]);
    }
}
