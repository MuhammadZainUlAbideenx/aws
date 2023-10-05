<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Http\Resources\CMS\OrdersResource;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Requests\CMS\Reports\SaleReportsRequest;
use App\Http\Requests\CMS\Reports\CustomerReportsRequest;
use App\Http\Requests\CMS\Reports\ProductReportsRequest;
use App\Http\Requests\CMS\Reports\OrderReportsRequest;
use App\Http\Resources\CMS\ProductsResource;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Setting;
use PDF;

class ReportsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
          $this->middleware('auth:api');
    }

    /********* Sale Getter For Pagination, Searching And Sorting  ***********/
    public function salesGetter($req = null, $export = null)
    {
        if ($req != null) {
            $orders = Order::where('parent_order_id',0)->withAll();
            if ($req->date_from && $req->date_from != null && $req->date_to && $req->date_to != null) {
                $req->date_from = date('Y-m-d',strtotime($req->date_from));
                $req->date_to = date('Y-m-d',strtotime($req->date_to));
                $orders = $orders->whereBetween('created_at', [$req->date_from . " 00:00:00", $req->date_to . " 23:59:59"])->where('is_paid', 1);
            }
            if ($req->column && $req->column != null && $req->search && $req->search != null) {

                $orders = $orders->whereLike($req->column, $req->search);
            } else if ($req->search && $req->search != null) {
                $orders = $orders->whereLike(['order_number'], $req->search);
            }
            if ($export != null) { // for export do not paginate
                $orders = $orders->get();
                return $orders;
            }
            $totalOrders = $orders->count();
            $orders = $orders->paginate($req->perPage);
            $orders = OrdersResource::collection($orders)->response()->getData(true);
            return $orders;
        }
        $orders = Order::where('parent_order_id',0)->withAll()->orderBy('id', 'desc')->paginate(10);
        $orders = OrdersResource::collection($orders)->response()->getData(true);
        return $orders;
    }

    public function getFilteredSaleReports(SaleReportsRequest $request)
    {
        $response = generateResponse($this->salesGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function saleExport(Request $request)
    {
        // $sales = $this->salesGetter($request, "export");
        // $filename = "SaleReport." . $request->export;
        // return Excel::download(new SaleReportExport($sales), $filename);
        $sales = $this->salesGetter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'dateFrom' => date('d-m-Y', strtotime($request->date_from)),
                'dateTo' => date('d-m-Y', strtotime($request->date_to)),
                'currentDate' => date("d-m-Y"),
                'fileName' => "SaleReportExport",
                'reportName' => "Sale Report",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Order Number", "Payment Method", "Sub Total", "Shipping Price", "Coupon Amount", "Total"];
            $data['tableData'] = [];
            $data['sub_total'] = [];
            $data['shipping_price'] = [];
            $data['coupon_amount'] = [];
            $data['total'] = [];
            foreach ($sales as $key => $sale) {
                if ($sale->coupon_amount){
                    $coupon_amt = $sale->coupon_amount;
                }else{
                    $coupon_amt = 0;
                }
                $result = [++$key, $sale->order_number, $sale->payment_method->name, attachCurrencyDecimal($sale->sub_total), attachCurrencyDecimal($sale->shipping_price), attachCurrencyDecimal($coupon_amt), attachCurrencyDecimal($sale->total)];
                $data['tableData'][] = $result;
                $data['sub_total'][] += $sale->sub_total;
                $data['shipping_price'][] += $sale->shipping_price;
                $data['coupon_amount'][] += $sale->coupon_amount;
                $data['total'][] += $sale->total;
            }
            // dd(array_sum($data['total']));
            $pdf = PDF::loadView('pdf.reports', $data);
            return $pdf->setPaper('A4', 'potrait')->download('sale.pdf');
        }
    }

    /********* FILTER Orders FOR Search ***********/
    public function filter(Request $request)
    {
        return response()->json(["state" => "success", "message" => "Filter Orders Successfully", "orders" => $this->getter($request)]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($order)
    {
        $order = Order::where('parent_order_id',0)->withAll()->find($order);
        return new OrdersResource($order);
    }

    /********* Customer Getter For Pagination, Searching And Sorting  ***********/
    public function customersGetter($req = null, $export = null)
    {
        if ($req != null) {
            $customers = Customer::withAll();
            if ($req->date_from && $req->date_from != null && $req->date_to && $req->date_to != null) {
                $req->date_from = date('Y-m-d',strtotime($req->date_from));
                $req->date_to = date('Y-m-d',strtotime($req->date_to));
                $customers = $customers->whereBetween('created_at', [$req->date_from . " 00:00:00", $req->date_to . " 23:59:59"]);
            }
            if ($req->column && $req->column != null && $req->search && $req->search != null) {

                $customers = $customers->whereLike($req->column, $req->search);
            } else if ($req->search && $req->search != null) {
                $customers = $customers->whereLike(['order_number'], $req->search);
            }
            if ($export != null) { // for export do not paginate
                $customers = $customers->get();
                return $customers;
            }
            $totalOrders = $customers->count();
            $customers = $customers->paginate($req->perPage);
            $customers = CustomersResource::collection($customers)->response()->getData(true);
            return $customers;
        }
        $customers = Customer::withAll()->orderBy('id', 'desc')->paginate(10);
        $customers = CustomersResource::collection($customers)->response()->getData(true);
        return $customers;
    }

    public function getFilteredCustomerReports(CustomerReportsRequest $request)
    {
        $response = generateResponse($this->customersGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function customerExport(Request $request)
    {
        $customers = $this->customersGetter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'dateFrom' => date('d-m-Y', strtotime($request->date_from)),
                'dateTo' => date('d-m-Y', strtotime($request->date_to)),
                'currentDate' => date("d-m-Y"),
                'fileName' => "CustomerReportExport",
                'reportName' => "Customer Report",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "First Name", "Last Name", "Date of Birth", "Phone", "Email", "Gender", "Status"];
            $data['tableData'] = [];
            $is_active = '';
            foreach ($customers as $key => $customer) {
                if ($customer->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                $result = [++$key, $customer->first_name, $customer->last_name, date('d-m-Y', strtotime($customer->dob)), $customer->phone, $customer->email, $customer->gender, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.reports', $data);
            return $pdf->setPaper('A4', 'potrait')->download('customer.pdf');
        }
    }

    /********* Product Getter For Pagination, Searching And Sorting  ***********/
    public function productsGetter($req = null, $export = null)
    {
        if ($req != null) {

            $products = Product::withAll()->with('order_products')->with('variants');
            if ($req->date_from && $req->date_from != null && $req->date_to && $req->date_to != null) {
                $req->date_from = date('Y-m-d',strtotime($req->date_from));
                $req->date_to = date('Y-m-d',strtotime($req->date_to));
                $products = $products->whereBetween('created_at', [$req->date_from . " 00:00:00", $req->date_to . " 23:59:59"]);
            }

            if ($req->status != null) {

                $products = $products->where('is_active', $req->status);
            }
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                $products = $products->whereLike($req->column, $req->search);
            } else if ($req->search && $req->search != null) {
                $products = $products->whereLike(['order_number'], $req->search);
            }
            if ($export != null) { // for export do not paginate
                $products = $products->get();
                return $products;
            }
            $totalOrders = $products->count();
            $products = $products->paginate($req->perPage);
            $products = ProductsResource::collection($products)->response()->getData(true);
            return $products;
        }
        $products = Product::withAll()->orderBy('id', 'desc')->paginate(10);
        $products = ProductsResource::collection($products)->response()->getData(true);
        return $products;
    }

    public function getFilteredProductReports(ProductReportsRequest $request)
    {
        $response = generateResponse($this->productsGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function productExport(Request $request)
    {
        // $products = $this->productsGetter($request, "export");
        // $filename = "ProductReport." . $request->export;
        // return Excel::download(new ProductReportExport($products), $filename);
        $products = $this->productsGetter($request, "export");

        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'dateFrom' => date('d-m-Y', strtotime($request->date_from)),
                'dateTo' => date('d-m-Y', strtotime($request->date_to)),
                'currentDate' => date("d-m-Y"),
                'fileName' => "ProductReportExport",
                'reportName' => "Product Report",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Product Name", "Manufacturer", "Price", "Product Type", "Variants",  "SKU", "Stock", "Orders", "Status", "Feature"];
            $data['tableData'] = [];
            $product_type = '';
            $product_variants = '';
            $variants = [];
            foreach ($products as $key => $product) {
                if ($product->product_type == 1) {
                    $product_type = 'Simple';
                    $product_price =  $product->price;
                    $product_variants = "None";
                } else {
                    $product_type = 'Variable';
                    $product_price =  $product->variants->min('price');
                   foreach($product->attributes as $attribute){
                    foreach($product->product_attribute_values as $attribute_value){
                    $variants['attribute_name'][] = $attribute->name;
                    $variants['attribute_value'][] = $attribute_value->name;
                   }
                }
                $product_variants = array_combine($variants['attribute_name'],$variants['attribute_value']);
                $product_variants = implode(",",$product_variants);
                }
                if ($product->is_active == 1) {
                    $is_active = 'Active';
                } else {
                    $is_active = 'Inactive';
                }
                if ($product->is_feature == 1) {
                    $is_feature = 'Featured';
                } else {
                    $is_feature = 'Non-Featured';
                }
                $result = [++$key, $product->name, $product->manufacturer->name, attachCurrencyDecimal($product_price), $product_type, $product_variants , $product->sku, $product->stock, $product->product_ordered, $is_active, $is_feature];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.reports', $data);
            return $pdf->setPaper('A4', 'landscape')->download('product.pdf');
        }
    }
    /********* Order Getter For Pagination, Searching And Sorting  ***********/
    public function ordersGetter($req = null, $export = null)
    {
        if ($req != null) {
            $orders = Order::where('parent_order_id',0)->withAll()->withReportDetail();
            if ($req->date_from && $req->date_from != null && $req->date_to && $req->date_to != null) {
                $req->date_from = date('Y-m-d',strtotime($req->date_from));
                $req->date_to = date('Y-m-d',strtotime($req->date_to));
                $orders = $orders->whereBetween('created_at', [$req->date_from . " 00:00:00", $req->date_to . " 23:59:59" ]);
            }

            if ($req->status != null) {

                $orders = $orders->where('order_status_id', $req->status);
            }
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                $orders = $orders->whereLike($req->column, $req->search);
            } else if ($req->search && $req->search != null) {
                $orders = $orders->whereLike(['order_number'], $req->search);
            }
            if ($export != null) { // for export do not paginate
                $orders = $orders->get();
                return $orders;
            }
            $totalOrders = $orders->count();
            $orders = $orders->paginate($req->perPage);
            $orders = OrdersResource::collection($orders)->response()->getData(true);
            return $orders;
        }
        // $orders = Order::where('parent_order_id',0)->withAll()->orderBy('id', 'desc')->paginate(10);
        // $orders = OrdersResource::collection($orders)->response()->getData(true);
        // return $orders;
    }

    public function getFilteredOrderReports(OrderReportsRequest $request)
    {
        $response = generateResponse($this->ordersGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function orderExport(Request $request)
    {
        $orders = $this->ordersGetter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);

            $data['general'] = [
                'dateFrom' => date('d-m-Y', strtotime($request->date_from)),
                'dateTo' => date('d-m-Y', strtotime($request->date_to)),
                'currentDate' => date("d-m-Y"),
                'fileName' => "OrderReportExport",
                'reportName' => "Order Report",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Number", "Customer Name", "Order Status", "Payment Method", "Sub Total", "Shipping Amount", "Coupon Amount", "Total"];
            $data['tableData'] = [];
            foreach ($orders as $key => $order) {
                if ($order->coupon_amount){
                    $coupon_amt = $order->coupon_amount;
                }else {
                    $coupon_amt = 0;
                }
                $result = [++$key, $order->order_number, $order->customer->first_name, $order->order_status->name, $order->payment_method->name, attachCurrencyDecimal($order->sub_total), attachCurrencyDecimal($order->shipping_price), attachCurrencyDecimal($coupon_amt), attachCurrencyDecimal($order->total)];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.reports', $data);
            return $pdf->setPaper('A4', 'potrait')->download('order.pdf');
        }
    }
}
