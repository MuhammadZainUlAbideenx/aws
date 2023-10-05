<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\CMSModels\OrderProductVariantDetails;
use App\Models\CMSModels\CartAttributeValueName;
use App\Http\Resources\Web\PaymentMethodsResource;
use App\Models\CMSModels\PaymentMethod;
use App\Models\CMSModels\OrderStatus;
use App\Http\Resources\Web\CartResource;
use App\Mail\OrderConfirmationmail;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\OrderProduct;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\RiderShipping;
use App\Models\CMSModels\Setting;
use App\Models\CMSModels\ShippingMethodSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiOrdersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }

    // Posts
    public static function index()
    {
    }

    public function create($request, $customer, $is_paid, $transaction_details)
    {

        $response = [];
        $cart_items = [];
        if (count($transaction_details) > 0) {
            if ($transaction_details['captured'] == true) {
                $transaction_status = 'captured';
            } else {
                $transaction_status = 'un_captured';
            }
        } else {
            $transaction_status = 'captured';
        }
        $payment_method_settings = new PaymentMethodsResource(PaymentMethod::withAll()->where('code', $request['payment_method_code'])->first());
        // $rider_shipping_method = ShippingMethod::where('id', 6)->first();
        // if ($rider_shipping_method->is_default == 1) {
        //     $shipping_method_settings = new ShippingMethodsResource(ShippingMethod::withAll()->where('id', 6)->first());
        //     $shipping_price = 0;
        //     foreach($shipping_method_settings->orders as $shipping_order){
        //         if($shipping_order->vendor_id == 0 && $shipping_order->parent_order_id == 0){
        //             $rider_shipping = RiderShipping::where('vendor_id', 1)->first();
        //             $shipping_price = $rider_shipping->commission_rate;
        //         }
        //     }


        // } else {

        //     $shipping_method_settings = new ShippingMethodsResource(ShippingMethod::withAll()->where('id', $request['shipping_id'])->first());
        //     $shipping_price = 0;
        //     foreach ($shipping_method_settings->settings as $setting) {
        //         if ($setting->name == 'rate') {
        //             // $shipping_price = $setting->value;
        //             $shipping_price = $request['shipping_value'];
        //             break;
        //         } else {
        //             $shipping_price = $request['shipping_value'];
        //         }
        //     }

        // }
        $cartItems = $customer->cartItems()->where('is_ordered', 0)->get();
        // check vendor ids is same or not for generating a sub order
        $allVendors = array();
        foreach ($cartItems as $cartItem) {
            array_push($allVendors, $cartItem->product->vendor_id);
        }

        if ($cartItems) {
            //Generating Order
            $default_order_status = OrderStatus::where('is_default', 1)->first();
            $cart_items['order_status_id'] = $default_order_status->status_code;
            $cart_items['is_active'] = 1;
            $cart_items['payment_method_id'] = $payment_method_settings->id;
            $cart_items['shipping_method_id'] = $request['shipping_id'];
            $cart_items['description'] = "Order Generated";
            $cart_items['is_paid'] = $is_paid;

            // for admin products order(single store)
            $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();

            if ((int)$allSettings['is_multi_vendor'] === 0) {
                $order = $customer->orders()->create([
                    'order_status_id' => $default_order_status->status_code,
                    'transaction_id' => $transaction_details && $transaction_details['data'] && $transaction_details['data']['capture_id'] ?   $transaction_details['data']['capture_id'] : null,
                    'transaction_status' => $transaction_status,
                    'payment_method_id' => $payment_method_settings->id,
                    'shipping_method_id' => $request['shipping_id'],
                    'current_currency_sub_total' => $request['current_currency_sub_total'],
                    'current_currency_shipping_price' => $request['shipping_value'],
                    'current_currency_value' => $request['current_currency_value'],
                    'customer_id' => $customer->id,
                    'total' => $request['total'],
                    'sub_total' => $request['sub_total'],
                    'order_number' => uniqid("order_"),
                    'parent_order_id' => 0,
                    'vendor_id' => 1,
                    'default_currency_total' => $request['default_currency_total'],
                    'current_currency' => $request['current_currency'],
                    'current_currency_total' => $request['current_currency_total'],
                    'default_currency' => $request['default_currency'],
                    'default_currency_value' => $request['default_currency_value'],
                    //  'usd_currency_value' => $request['usd_currency_value'],
                    'shipping_price' => $request['shipping_value'],
                    'is_paid' => $is_paid,
                    'is_active' => 1,
                    'is_coupon_applied' => $request['coupon_id'] ? 1 : 0,
                    'coupon_code' => $request['coupon_id'] ? $request['coupon_code'] : null,
                    'coupon_amount' => $request['coupon_id'] ? $request['coupon_amount'] : null,
                    'coupon_id' => $request['coupon_id'] ? $request['coupon_id'] : null,
                ]);
            } else {

                // multi vendors order generate
                if (count(array_unique($allVendors)) === 1 && (int)$allSettings['is_multi_vendor'] === 1) {
                    $vendor_id = $allVendors[0];
                    $order = $customer->orders()->create([
                        'order_status_id' => $default_order_status->status_code,
                        'transaction_id' => $transaction_details && $transaction_details['data'] && $transaction_details['data']['capture_id'] ?   $transaction_details['data']['capture_id'] : null,
                        'transaction_status' => $transaction_status,
                        'payment_method_id' => $payment_method_settings->id,
                        'shipping_method_id' => $request['shipping_id'],
                        'current_currency_sub_total' => $request['current_currency_sub_total'],
                        'current_currency_shipping_price' => $request['current_currency_shipping_price'],
                        'current_currency_value' => $request['current_currency_value'],
                        'customer_id' => $customer->id,
                        'total' => $request['total'],
                        'sub_total' => $request['sub_total'],
                        'order_number' => uniqid("order_"),
                        'parent_order_id' => 0,
                        'vendor_id' => $vendor_id,
                        'default_currency_total' => $request['default_currency_total'],
                        'current_currency' => $request['current_currency'],
                        'current_currency_total' => $request['current_currency_total'],
                        'default_currency' => $request['default_currency'],
                        'default_currency_value' => $request['default_currency_value'],
                        //  'usd_currency_value' => $request['usd_currency_value'],
                        'shipping_price' => $request['shipping_value'],
                        'is_paid' => $is_paid,
                        'is_active' => 1,
                        'is_coupon_applied' => $request['coupon_id'] ? 1 : 0,
                        'coupon_code' => $request['coupon_id'] ? $request['coupon_code'] : null,
                        'coupon_amount' => $request['coupon_id'] ? $request['coupon_amount'] : null,
                        'coupon_id' => $request['coupon_id'] ? $request['coupon_id'] : null,
                    ]);
                }
                if (count(array_unique($allVendors)) != 1) {
                    $order = $customer->orders()->create([
                        'order_status_id' => $default_order_status->status_code,
                        'transaction_id' => $transaction_details && $transaction_details['data'] && $transaction_details['data']['capture_id'] ?   $transaction_details['data']['capture_id'] : null,
                        'transaction_status' => $transaction_status,
                        'payment_method_id' => $payment_method_settings->id,
                        'shipping_method_id' => $request['shipping_id'],
                        'current_currency_sub_total' => $request['current_currency_sub_total'],
                        'current_currency_shipping_price' => $request['current_currency_shipping_price'],
                        'current_currency_value' => $request['current_currency_value'],
                        'customer_id' => $customer->id,
                        'total' => $request['total'],
                        'sub_total' => $request['sub_total'],
                        'order_number' => uniqid("order_"),
                        'parent_order_id' => 0,
                        'vendor_id' => 0,
                        'default_currency_total' => $request['default_currency_total'],
                        'current_currency' => $request['current_currency'],
                        'current_currency_total' => $request['current_currency_total'],
                        'default_currency' => $request['default_currency'],
                        'default_currency_value' => $request['default_currency_value'],
                        //  'usd_currency_value' => $request['usd_currency_value'],
                        'shipping_price' => $request['shipping_value'],
                        'is_paid' => $is_paid,
                        'is_active' => 1,
                        'is_coupon_applied' => $request['coupon_id'] ? 1 : 0,
                        'coupon_code' => $request['coupon_id'] ? $request['coupon_code'] : null,
                        'coupon_amount' => $request['coupon_id'] ? $request['coupon_amount'] : null,
                        'coupon_id' => $request['coupon_id'] ? $request['coupon_id'] : null,
                    ]);


                    // check multiple vendors

                    $collectCartItems = collect($cartItems);
                    $cartItemsVendorId = $collectCartItems->groupBy(function ($item) {
                        return $item->product->vendor_id;
                    });



                    foreach ($cartItemsVendorId as $vendor_id => $vendorcartItems) {
                        $itemSum = $vendorcartItems->sum(function ($item) {

                            if ($item->product->product_type == 1) {

                                if ($item->product->flash_sale && $item->product->flash_sale->expire_date >= Carbon::now()->toISOString()) {
                                    return $item->quantity * $item->product->flash_sale->product_price;
                                }
                                if ($item->product->special_sale && $item->product->special_sale->expire_date >= Carbon::now()->toISOString()) {
                                    return $item->quantity * $item->product->special_sale->special_price;
                                }
                                return $item->quantity * $item->product->price;
                            } else {
                                $variant = $item->product->variants()->where('variant', $item->variant)->first();
                                return $item->quantity *  $variant->price;
                            }
                        });
                        if ($vendor_id) {

                            // calculating a shipping for a sub orders starts
                            if ($request['shipping_id'] == 2) {
                                // free shipping
                                $shipping_value =  0;
                            }
                            if ($request['shipping_id'] == 3) {
                                // local pickup  shipping
                                $shipping_value =  0;
                            }
                            if ($request['shipping_id'] == 6) {
                                // shipping by rider
                                $total_commission_percentage = 0;

                                // foreach ($cartItems as $cart) {
                                // $cart_vendor_id = $cart->product->vendor_id;

                                $riderCommission = RiderShipping::where('vendor_id', $vendor_id)->first();

                                if ($riderCommission) {
                                    $commission_type =  $riderCommission->commission_type;
                                    $commission_rate =  $riderCommission->commission_rate;

                                    if ($commission_type == 0) {
                                        // percentage commission
                                        foreach ($cartItems as $cart) {
                                            if ($cart->product_id == $cart->product->id && $vendor_id == $cart->product->vendor_id) {
                                                $qty = $cart->quantity;
                                                if ($cart->variant != null) {

                                                    $variant = $cart->variant;
                                                    foreach ($cart->product->variants as $product_variant) {
                                                        if ($variant ==  $product_variant->variant) {
                                                            $total = $product_variant->price * $qty;
                                                            $total_commission_percentage += $total / 100 * $riderCommission->commission_rate;
                                                        }
                                                    }
                                                } else {

                                                    if ($cart->product->special_sale && $cart->product->special_sale->is_active == 1) {

                                                        $total = $cart->product->special_sale->special_price * $qty;
                                                        $total_commission_percentage += $total / 100 * $riderCommission->commission_rate;
                                                    } else if ($cart->product->flash_sale && $cart->product->flash_sale->is_active == 1) {

                                                        $total = $cart->product->flash_sale->product_price * $qty;
                                                        $total_commission_percentage += $total / 100 * $riderCommission->commission_rate;
                                                    } else {

                                                        $total = $cart->product->price * $qty;
                                                        $total_commission_percentage += $total / 100 * $riderCommission->commission_rate;
                                                    }
                                                }
                                            }
                                        }
                                        if ($commission_type == 1 && $vendor_id == $cart->product->vendor_id) {
                                            // fixed commission
                                            $total_commission_percentage += $commission_rate;
                                        }
                                    }
                                }

                                $shipping_value = number_format((float)$total_commission_percentage, 2, '.', '');
                            }
                            if ($request['shipping_id'] == 1) {
                                // fixed shipping
                                $shippingMethodSetting = ShippingMethodSetting::where('shipping_method_id', 1)->where('name', 'rate')->first();
                                $shipping_value =  $shippingMethodSetting->value;
                            }

                            if ($request['shipping_id'] == 5) {
                                // shipping by weight
                                $shippingMethodSetting = ShippingMethodSetting::where('shipping_method_id', 5)->where('name', 'rate')->first();
                                $weightValue = $shippingMethodSetting->value;
                                foreach ($cartItems as $cart) {
                                    if ($vendor_id == $cart->product->vendor_id) {
                                        $productWeight = $cart->product->shipping_weight * $cart->quantity;
                                        $shipping_value = $productWeight * $weightValue;
                                    }
                                }
                            }


                            // calculating a shipping for a sub orders ends

                            $sub_order = $customer->orders()->create([
                                'order_status_id' => $default_order_status->status_code,
                                'transaction_id' => $transaction_details && $transaction_details['data'] && $transaction_details['data']['capture_id'] ?   $transaction_details['data']['capture_id'] : null,
                                'transaction_status' => $transaction_status,
                                'payment_method_id' => $payment_method_settings->id,
                                'shipping_method_id' => $request['shipping_id'],
                                'current_currency_sub_total' => $itemSum,
                                // 'current_currency_shipping_price' => $request['current_currency_shipping_price'],
                                'current_currency_shipping_price' => $shipping_value,
                                'current_currency_value' => $request['current_currency_value'],
                                'customer_id' => $customer->id,
                                'total' => $itemSum +  $shipping_value,
                                'sub_total' => $itemSum,
                                'order_number' => uniqid("order_"),
                                'parent_order_id' => $order->id,
                                'vendor_id' => $vendor_id,
                                'default_currency_total' => $itemSum +  $shipping_value,
                                'current_currency' => $request['current_currency'],
                                'current_currency_total' => $itemSum +  $shipping_value,
                                'default_currency' => $request['default_currency'],
                                'default_currency_value' => $request['default_currency_value'],
                                //  'usd_currency_value' => $request['usd_currency_value'],
                                'shipping_price' => $shipping_value,
                                'is_paid' => $is_paid,
                                'is_active' => 1,
                                'is_coupon_applied' => $request['coupon_id'] ? 1 : 0,
                                'coupon_code' => $request['coupon_id'] ? $request['coupon_code'] : null,
                                'coupon_amount' => $request['coupon_id'] ? $request['coupon_amount'] : null,
                                'coupon_id' => $request['coupon_id'] ? $request['coupon_id'] : null,
                            ]);
                        }
                    }
                }
            }


            // declare a var outside the loop and send through parameter starts
            $total_product_price = 0;
            // declare a var outside the loop and send through parameter ends
            if ($order) {
                $cartItems = $customer->cartItems()->where('is_ordered', 0)->get();
                $cartItems_resource = CartResource::collection($cartItems);
                foreach ($cartItems_resource as $key => $cartItem) {
                    $cartItem = collect($cartItem);
                    if ($cartItem['product']['flash_sale'] && $cartItem['product']['flash_sale']->expire_date >= Carbon::now()->toISOString()) {

                        $sale_type = 'flash_sale';
                        $sale_price_default = $cartItem['single_default_price_float'];
                        //    $total_price_default = $sale_price_default * $cartItem['quantity'];
                        $sale_price_current = $cartItem['single_current_price_float'];
                        $total_sale_price_current = $sale_price_current * $cartItem['quantity'];
                        $sale_price_usd = $cartItem['single_usd_price_float'];
                        $total_sale_price_usd = $sale_price_usd * $cartItem['quantity'];
                    } else if ($cartItem['product']['special_sale'] && $cartItem['product']['special_sale']->expire_date >= Carbon::now()->toISOString()) {

                        $sale_type = 'special_sale';
                        $sale_price_default = $cartItem['single_default_price_float'];
                        //    $total_price_default = $sale_price_default * $cartItem['quantity'];
                        $sale_price_current = $cartItem['single_current_price_float'];
                        $total_sale_price_current = $sale_price_current * $cartItem['quantity'];
                        $sale_price_usd = $cartItem['single_usd_price_float'];
                        $total_sale_price_usd = $sale_price_usd * $cartItem['quantity'];
                    } else {
                        $sale_type = null;
                        $sale_price_default = 0;
                        $sale_price_current = 0;
                        $total_sale_price_current = 0;
                        $sale_price_usd = 0;
                        $total_sale_price_usd = 0;
                    }
                    //Without Sale Prices
                    $single_price_default = $cartItem['single_default_price_without_sale'];
                    $total_price_default =  $single_price_default * $cartItem['quantity']; // $single_price_default * quantity
                    $single_price_current =  $cartItem['single_current_price_without_sale'];
                    $total_price_current = $single_price_current * $cartItem['quantity']; // $single_price_current * quantity
                    $single_price_usd =   $cartItem['single_usd_price_without_sale'];
                    $total_price_usd = $single_price_usd * $cartItem['quantity'];
                    //Without Sale Prices


                    $order_product = $order->order_products()->create([
                        'order_id' => $order->id,
                        'vendor_id' => $allVendors[$key],
                        'quantity' => $cartItem['quantity'],
                        'product_id' => $cartItem['product']['id'],
                        'sale_type' => $sale_type,
                        'sale_price_current' => $sale_price_current,
                        'total_sale_price_current' => $total_sale_price_current,
                        //  'sale_price_usd' => $sale_price_usd,
                        //  'total_sale_price_usd' => $total_sale_price_usd,
                        'single_price_current' => $single_price_current,
                        'total_price_current' => $total_price_current,
                        'single_price_default' => $single_price_default,
                        'total_price_default' => $total_price_default,
                        //  'single_price_usd' => $single_price_usd,
                        //  'total_price_usd' => $total_price_usd,
                        'variant' => $cartItem['variant'],
                    ]);
                    $product_price = $order_product->total_price_current;

                    $prod = Product::where('id', $order_product->product_id)->first();
                    $category = $prod->categories()->where('parent_id', 0)->first();
                    $category_id  =  $category->id;
                    $commission = DB::table('commission_categories')->where('category_id', $category_id)->first();
                    if ($commission) {
                        $rate = $commission->rate;
                        $rate_type = $commission->rate_type;
                        $commission_fixed_amount = $commission->commission_min_amount_fixed;
                        if ((int)$allSettings['vendor_commission_type'] == 0) {
                            // if vendor commission  type = 0, its means its  commission on categories
                            $commission_type = 0;
                        } else {
                            $commission_type = 1;
                        }

                        $commission_amount = calculateCommission($commission_type, $product_price, $rate, $rate_type, $commission_fixed_amount, $total_product_price);
                        // update commsion type rate in a order product table

                        $order->order_products()->where('id', $order_product->id)->update([
                            'commission_type' => $commission_type,
                            'commission_rate_type' => $rate_type,
                            'commission_rate' => $rate,
                            'commission_amount' => $commission_amount,
                        ]);

                        $commission = OrderProduct::select('commission_amount', 'vendor_id')->where('id', $order_product->id)->first();
                        $commission_amount = $commission->commission_amount;
                        $order_id = $order->id;
                        $vendor_id = $commission->vendor_id;



                        // if commission is saved already in orders then plus another commission
                        $get_commission = Order::where('parent_order_id', $order_id)->where('vendor_id', $vendor_id)->first();
                        if(!$get_commission){
                            $get_commission = Order::where('id', $order_id)->where('vendor_id', $vendor_id)->first();
                        }


                        if ($get_commission) {
                            $get_commission = $get_commission->commission_amount;
                            $commission_amount = $get_commission +  $commission_amount;
                        }
                        $update_order_commission = $order->where('parent_order_id', $order_id)->where('vendor_id', $vendor_id)->update([
                            'commission_type' => $commission_type,
                            'commission_amount' => $commission_amount,
                        ]);
                        if (!$update_order_commission) {
                            $order->where('id', $order_id)->where('vendor_id', $vendor_id)->update([
                                'commission_type' => $commission_type,
                                'commission_amount' => $commission_amount,
                            ]);
                        }
                    }




                    if ($cartItem['variant'] != null || $cartItem['variant'] != '') {
                        $cart_arrtiburtes_values = CartAttributeValueName::where('cart_id', $cartItem['id'])->get();
                        if ($cart_arrtiburtes_values) {
                            foreach ($cart_arrtiburtes_values as $cart_arrtiburtes_value) {
                                $cart_arrtiburtes_value = OrderProductVariantDetails::create([
                                    'order_product_id' => $order_product->id,
                                    'attribute_name' => $cart_arrtiburtes_value->attribute_name,
                                    'value_name' => $cart_arrtiburtes_value->value_name,
                                ]);
                            }
                        }
                    }
                }

                // calculate total commission price
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product()->first();
                    if ($cartItem->variant) {
                        $product_variant = $product->variants()->where('variant', $cartItem->variant)->first();
                        $product_variant->update([
                            'stock' => $product_variant->stock - $cartItem->quantity,
                        ]);
                    } else {
                        $product->update([
                            'stock' => $product->stock - $cartItem->quantity,
                        ]);
                    }
                    $cartItem->update([
                        'is_ordered' => 1,
                    ]);
                }
                //Order Generated
                //Addresses Generation
                $shipping_address = $request['shipping_address'];
                $shipping_address['order_id'] = $order->id;
                $shipping_address['address_type'] = 'shipping';
                $shipping_address = $order->order_addresses()->create($shipping_address);
                $billing_address = $request['billing_address'];
                $billing_address['order_id'] = $order->id;
                $billing_address['address_type'] = 'billing';
                $billing_address = $order->order_addresses()->create($billing_address);
                $response['success'] = true;
                $response['order_id'] = $order->id;
                $response['order_number'] = $order->order_number;

                $this->sendOrderConfirmationMail($order->id);


                return $response;
            } else {
                //Order Not Generated
                $response['success'] = false;
                return $response;
            }
        } else {
            return response()->json(["message" => trans('messages.response.web.cart_not_found')]);
        }
    }

    public function update($brand)
    {
    }

    public function sendOrderConfirmationMail($order_id)
    {
        $order = Order::find($order_id);
        if (count($order->order_addresses) > 0) {
            $user_email = $order->order_addresses[0]->email;
        } else {
            $user_email = $order->vendor_order_addresses[0]->email;
        }
        Mail::to($user_email)->send(new OrderConfirmationmail($order));
    }
}
