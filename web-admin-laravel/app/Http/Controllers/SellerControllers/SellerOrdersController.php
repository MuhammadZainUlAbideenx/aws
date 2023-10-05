<?php

namespace App\Http\Controllers\SellerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\Product;
use App\Http\Requests\CMS\Orders\CreateRequest;
use App\Http\Resources\Vendor\OrdersResource;
use Excel;
use App\Models\CMSModels\OrderProduct;
use App\Exports\CMS\OrdersExport;
use App\Http\Controllers\GeneralControllers\WalletController;
use App\Http\Resources\CMS\OrderStatusesResource;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\OrderStatus;
use App\Models\CMSModels\ProductVariant;
use App\Models\CMSModels\Setting;
use Illuminate\Support\Facades\Validator;
use PDF;

class SellerOrdersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
    }

    /********* Getter For Pagination, Searching And Sorting  ***********/
    public function getter($req = null, $export = null)
    {
        // check a produts in a order_products and get order ids
        $vendor_product_orders = OrderProduct::whereHas('product', function ($q) {
            $q->where('vendor_id', auth()->user()->id);
        })->groupBy('order_id')->get();
        $order_ids = $vendor_product_orders->pluck('order_id')->toArray();
        array_push($order_ids, 0);
        $orders = Order::withAllVendor()->where('vendor_id', auth()->user()->id)->whereIn('parent_order_id', $order_ids);
        if ($req != null) {
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
        $orders = $orders->orderBy('id', 'desc')->paginate(10);
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
                if ($order->payment_method_id == 1) {
                    $payment_method = "Direct Bank Transfer";
                } else if ($order->payment_method_id == 2) {
                    $payment_method = "Cash on Delivery";
                } else if ($order->payment_method_id == 8) {
                    $payment_method = "Wallet";
                } else if ($order->payment_method_id == 4) {
                    $payment_method = "Through Stripe";
                } else if ($order->payment_method_id == 5) {
                    $payment_method = "Through Braintree";
                } else if ($order->payment_method_id == 3) {
                    $payment_method = "Through Paypal";
                } else if ($order->payment_method_id == 9) {
                    $payment_method = "Through Razorpay";
                } else if ($order->payment_method_id == 10) {
                    $payment_method = "Through Flutterwave";
                }


                $result = [++$key, $order->order_number, $order->order_status->name, $order->total, $is_paid, $payment_method, $is_active];
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
        $order = Order::withAllVendor()->find($order);
        return new OrdersResource($order);
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
        return response()->json(["state" => "success", "message" => trans('messages.response.orders.update_status_success'), "orders" => $this->getter($request)]);
    }

    public function changeOrderStatus(Request $request)
    {
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
        if ($order->order_status_id != 23 || $order->order_status_id != 22) {
            $order_status = OrderStatus::find($request->order_status_id);
            if ($order_status) {
                $order->update([
                    'order_status_id' => $order_status->status_code,
                    'order_status_reason' => $request->order_status_reason,
                ]);
                // check if orderstatus is completed.
                $check_order_status = $order->order_status_id;
                if ($check_order_status == 7 && $order->is_paid == 1) {
                    // Transfer Commission amount to vendor Wallet
                    $total_amount = $order->current_currency_total - $order->commission_amount;
                    $wallet = new WalletController;
                    $result = $wallet->depositMoneyToVendorWallet($total_amount, $order->vendor_id, $order->order_number);
                }
                if ($check_order_status == 23 && $order->is_paid == 1) {
                    $wallet = new WalletController;
                    $result = $wallet->RefundAmountToCustomer($order->total, $order->customer_id, $order->order_number);
                }
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
                    if (count($updated_order->vendor_order_products) > 0) //When order is from multi vendors
                    {

                        foreach ($updated_order->vendor_order_products as $ordered_product) {
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
                return response(["message" => trans('messages.response.orders.update_success'), "changes_status_name" => new OrderStatusesResource($order_status)]);
            }
        } else {
            return response(["message" => trans('messages.response.orders.update_fails')]);
        }
    }
    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request, Order $order)
    {
        $order->delete();
        return response()->json(["state" => "success", "message" => trans('messages.response.orders.delete_success'), "orders" => $this->getter($request)]);
    }
}
