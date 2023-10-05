<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Vendor\SalesOrdersResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Sales;

class DashboardController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /********* FETCH ALL Admins ***********/
    public function index()
    {
        $all_orders = Order::where('parent_order_id', 0)->get();
        $orders_count = $all_orders->count();
        $products = Product::count();
        $customers = Customer::count();
        $sales = Order::sum('current_currency_sub_total');
        $sales = attachCurrencyDecimal($sales);
        $sales_details = $all_orders;
        $min_sale_amount = $sales_details->min('current_currency_sub_total');
        $max_sale_amount = $sales_details->max('current_currency_sub_total');
        $sales_details = SalesOrdersResource::collection($sales_details);
        $arr = ['orders' => $orders_count, 'products' => $products, 'customers' => $customers, 'sales' => $sales, 'min_sale_amount' => $min_sale_amount, 'max_sale_amount' => $max_sale_amount, 'sales_details' => $sales_details   ];

        return response()->json($arr);
    }
}
