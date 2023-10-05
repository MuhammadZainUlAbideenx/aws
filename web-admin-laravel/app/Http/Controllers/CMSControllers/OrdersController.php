<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Http\Requests\CMS\Orders\CreateRequest;
use App\Http\Resources\CMS\OrdersResource;
use App\Exports\CMS\OrdersExport;
use App\Http\Controllers\GeneralControllers\WalletController;
use App\Http\Resources\CMS\OrderStatusesResource;
use App\Http\Resources\Web\SubOrdersResource;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\OrderProduct;
use App\Models\CMSModels\OrderStatus;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\ProductVariant;
use App\Models\CMSModels\Setting;
use Illuminate\Support\Facades\Validator;
use PDF;
use Excel;
class OrdersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:orders.index,guard:api');
        $this->middleware('permission:orders.create,guard:api', ['only' => ['store']]);
        $this->middleware('permission:orders.update,guard:api', ['only' => ['update']]);
        $this->middleware('permission:orders.delete,guard:api', ['only' => ['destroy']]);
        $this->middleware('permission:orders.update|orders.is_active,guard:api', ['only' => ['updateStatus']]);
    }

    /********* Getter For Pagination, Searching And Sorting  ***********/
    public function getter($req = null, $export = null)
    {

        if ($req != null) {
            $orders = Order::where('parent_order_id', 0)->withAll();
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                if ($req->column == 'name') {
                    $orders = $orders->whereLike(['customer.first_name', 'customer.last_name'], $req->search);
                } else {
                    $orders = $orders->whereLike($req->column, $req->search);
                }
            } else if ($req->search && $req->search != null) {
                $orders = $orders->whereLike(['order_number'], $req->search);
            }
            if ($req->sort != null && $req->sort["field"] != null && $req->sort["type"] != null) {
                $orders = $orders->OrderBy($req->sort["field"], $req->sort["type"]);
            } else {
                $orders = $orders->OrderBy('id', 'desc');
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
        $orders = Order::withAll()->where('parent_order_id', 0)->orderBy('id', 'desc')->paginate(10);
        $orders = OrdersResource::collection($orders)->response()->getData(true);
        return $orders;
    }

    /********* FETCH ALL Orders ***********/
    public function index()
    {
        $arrayName = array('orders' => $this->getter());
        return response($arrayName);
    }
    /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $orders = $this->getter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Orders",
                'reportName' => "Orders",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Order Number", "Order Status", "Total", "Paid", "Payment Method", "Status"];
            $data['tableData'] = [];
            foreach ($orders as $key => $order) {
                if ($order->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                if ($order->is_paid == 1) {
                    $is_paid = "Yes";
                } else {
                    $is_paid = "No";
                }
                if($order->payment_method_id == 1 ){
                    $payment_method = "Direct Bank Transfer";
                }
                else if($order->payment_method_id == 2 ){
                    $payment_method = "Cash on Delivery";
                }
                else if ($order->payment_method_id == 8){
                    $payment_method = "Wallet";
                }
                else if ($order->payment_method_id == 4){
                    $payment_method = "Through Stripe";
                }
                else if($order->payment_method_id == 5){
                    $payment_method = "Through Braintree";
                }
                else if($order->payment_method_id == 3){
                    $payment_method = "Through Paypal";
                }
                else if($order->payment_method_id == 9){
                    $payment_method = "Through Razorpay";
                }
                else if($order->payment_method_id == 10){
                    $payment_method = "Through Flutterwave";
                }


                $result = [++$key, $order->order_number, $order->order_status->name, $order->total, $is_paid, $payment_method , $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('order.pdf');
        }
        $filename = "orders." . $request->export;
        return Excel::download(new OrdersExport($orders), $filename);
    }

    /********* FILTER Orders FOR Search ***********/
    public function filter(Request $request)
    {
        return response()->json(["state" => "success", "message" => trans('messages.response.orders.filter_success'), "orders" => $this->getter($request)]);
    }

    /********* ADD NEW Order ***********/
    public function store(CreateRequest $request)
    {
        Order::create($request->all());
        return response(["message" => trans('messages.response.orders.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($order)
    {
        $data = Order::withAll()->withAllDetail()->find($order);
        $sub_orders = Order::withAll()->with('vendor',function($q){
            $q->with('store');})->with('payment_method')->with('order_products')->with('vendor_order_products')->where('parent_order_id', $order)->get();
        $data['order'] = SubOrdersResource::collection($sub_orders);
        $data['sub_order'] = false;
        if (count($data['order']) > 0){
            $data['sub_order'] = true;
        }
        return new OrdersResource($data);
    }

    /********* UPDATE Order ***********/
    public function update(CreateRequest $request, Order $order)
    {
        $order->update($request->all());
        return response(["message" => trans('messages.response.orders.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'is_active' => $order->is_active == 1 ? 0 : 1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.order_status.update_status_success'), "orders" => $this->getter($request)]);
    }

    public function changeOrderStatus(Request $request)
    {
        $allSettings = Setting::select('name','value')->pluck('value','name')->toArray();
        $is_multivendor = (int)$allSettings['is_multi_vendor'];
        $validator = Validator::make(
            $request->all(),
            [
                'order_status_id' => 'required',
                'id' => 'required',
                'order_status_reason' => 'required_if:order_status_id,9,13'
            ],
            ['order_status_reason.required_if' => "Please Provide Valid Reason"]
        );
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }

        $order = Order::find($request->id);
        if($order->order_status_id != 23){
        $order_status = OrderStatus::find($request->order_status_id);
        $admin_sub_order = Order::where('parent_order_id', $request->id)->where('vendor_id', 1)->first();
        if ($admin_sub_order) {
            $admin_sub_order = $admin_sub_order->update([
                'order_status_id' => $order_status->status_code,
                'order_status_reason' => $request->order_status_reason,
            ]);
            if ($admin_sub_order->order_status_id == 7){
                $admin_sub_order = $admin_sub_order->update([
                    'is_paid' => 1,
                ]);
            }
        } else {
            $order_updated = $order->update([
                'order_status_id' => $order_status->status_code,
                'order_status_reason' => $request->order_status_reason,
            ]);

            if ($order->order_status_id == 7){
                $order_updated = $order->update([
                    'is_paid' => 1,
                ]);
            }

        }


        //Restock items if cancel or refund
        $updated_order = Order::with('order_products')->with('vendor_order_products')->find($request->id);
        if ($updated_order->order_status_id == 23 || $updated_order->order_status_id == 22) {
            // Restock items if cancel or refund
            if (count($updated_order->order_products) > 0) //When order is only single vendor
            {

                foreach ($updated_order->order_products as $ordered_product) {
                    $product_exist = Product::where('id', $ordered_product->product_id)->first();
                    if ($product_exist->product_type == 1) {
                        $product_exist->update(["stock" => $product_exist->stock + $ordered_product->quantity]);
                    }
                    if ($product_exist->product_type == 2) {
                        $order_products_detail = OrderProduct::where('order_id', $updated_order->id)->where('product_id', $product_exist->id)->get();
                        foreach ($order_products_detail as $single_order_product) {
                            $product_varient = ProductVariant::where('product_id', $single_order_product->product_id)->where('variant', $single_order_product->variant)->first();
                            if ($product_varient) {
                                $product_varient->update(["stock" => $product_varient->stock + $single_order_product->quantity]);
                            }
                        }
                    }
                }
            }
        }


        if($order->order_status_id == 23 && $order->is_paid == 1){
            $wallet = new WalletController;
            $result = $wallet->RefundAmountToCustomer($order->total, $order->customer_id, $order->order_number);
        }
        if ($is_multivendor == 1) {
            if ($order || $admin_sub_order) {
                //   check the statuses.....
                $subOrders = Order::where('parent_order_id', $request->id)->get();
                if (!$subOrders) {
                    $subOrders = Order::where('id', $request->id)->get();
                }

                $is_match = true;
                foreach ($subOrders as $subOrder) {
                    if ($subOrder->order_status_id != 8) {
                        $is_match = false;
                        break;
                    }
                }
                if ($is_match) {
                    $order->update([
                        'order_status_id' => 8,
                        'is_paid' => 1,
                        // 'order_status_reason' => null,
                    ]);
                }

                return response(["message" => trans('messages.response.orders.update_success'), "changes_status_name" => new OrderStatusesResource($order_status)]);
            } else {
                return response(["message" => trans('messages.response.orders.update_fails')]);
            }
        }
        else
        {
            return response(["message" => trans('messages.response.orders.update_success'), "changes_status_name" => new OrderStatusesResource($order_status)]);
        }

    }else{
        return response(["status" => false, "message" => trans('messages.response.orders.update_fails')]);
    }
}

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request, Order $order)
    {
        $order->delete();
        return response()->json(["state" => "success", "message" => trans('messages.response.orders.delete_success'), "orders" => $this->getter($request)]);
    }
}
