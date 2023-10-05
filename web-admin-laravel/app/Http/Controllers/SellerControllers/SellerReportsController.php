<?php

namespace App\Http\Controllers\SellerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Http\Resources\CMS\OrdersResource;
use App\Http\Requests\CMS\Reports\SaleReportsRequest;
use App\Http\Requests\CMS\Reports\ProductReportsRequest;
use App\Http\Requests\CMS\Reports\OrderReportsRequest;
use App\Http\Resources\CMS\ProductsResource;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Setting;
use PDF;

class SellerReportsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
        $this->middleware('scope:vendor');
    }

    /********* Sale Getter For Pagination, Searching And Sorting  ***********/
    public function salesGetter($req = null, $export = null)
    {
        if ($req != null) {
            $orders = Order::where('vendor_id',auth()->user()->id)->withAll();
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
        // $orders = Order::where('vendor_id',auth()->user()->id)->withAll()->orderBy('id', 'desc')->paginate(10);
        // $orders = OrdersResource::collection($orders)->response()->getData(true);
        // return $orders;
    }

    public function getFilteredSellerSaleReports(SaleReportsRequest $request)
    {
        $response = generateResponse($this->salesGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function saleSellerExport(Request $request)
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
                'currentDate' => date("Y-m-d"),
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
        $order = Order::where('vendor_id',auth()->user()->id)->withAll()->find($order);
        return new OrdersResource($order);
    }

    /********* Product Getter For Pagination, Searching And Sorting  ***********/
    public function productsGetter($req = null, $export = null)
    {
        if ($req != null) {
            $products = Product::where('vendor_id', auth()->user()->id)->withAll()->with('order_products')->with('variants');
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
        $products = Product::where('vendor_id', auth()->user()->id)->withAll()->orderBy('id', 'desc')->paginate(10);
        $products = ProductsResource::collection($products)->response()->getData(true);
        return $products;
    }

    public function getFilteredSellerProductReports(ProductReportsRequest $request)
    {
        $response = generateResponse($this->productsGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function productSellerExport(Request $request)
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
                'currentDate' => date("Y-m-d"),
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
            return $pdf->setPaper('A4', 'potrait')->download('product.pdf');
        }
    }
    /********* Order Getter For Pagination, Searching And Sorting  ***********/
    public function ordersGetter($req = null, $export = null)
    {
        if ($req != null) {
            $orders = Order::where('vendor_id',auth()->user()->id)->withAll()->withReportDetail();
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

        $orders = Order::where('vendor_id',auth()->user()->id)->withAll()->orderBy('id', 'desc')->paginate(10);
        $orders = OrdersResource::collection($orders)->response()->getData(true);
        return $orders;
    }

    public function getFilteredSellerOrderReports(OrderReportsRequest $request)
    {
        $response = generateResponse($this->ordersGetter($request), true, '', [], 'object');
        return response($response);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function orderSellerExport(Request $request)
    {
        $orders = $this->ordersGetter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);

            $data['general'] = [
                'dateFrom' => date('d-m-Y', strtotime($request->date_from)),
                'dateTo' => date('d-m-Y', strtotime($request->date_to)),
                'currentDate' => date("Y-m-d"),
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
