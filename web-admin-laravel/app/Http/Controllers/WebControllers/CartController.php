<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\ValidateCouponCodeRequest\ValidateCouponCodeRequest;
use App\Http\Resources\CMS\CouponsResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\Cart;
use App\Models\CMSModels\Product;
use App\Http\Resources\Web\CartResource;
use App\Http\Resources\Web\CouponsResource as WebCouponsResource;
use App\Models\CMSModels\Coupon;
use App\Models\CMSModels\Currency;
use App\Models\CMSModels\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    // All Cart Items
    public function index(Request $request){
      if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
       $customer = auth('customer-api')->user();
       $cart_items = $customer->cartItems()->where('is_ordered',0)->get();
      }
      else{
        $customer = null;
        $session_token = $request->cookie('session_token');
        $cart_items = Cart::withAll()->where('session_token',$session_token)->where('is_ordered',0)->whereNotNull('session_token')->get();
      }
        $count_items = count($cart_items);
        $cart_items = CartResource::collection($cart_items);
        $current_currency = session('current_currency');
        // dd($cart_items);
        $subtotal = $cart_items->sum(function($q) use($current_currency){
          $q = collect($q);
          $price = get_price_float($q['price']);
          return $price;
        });
        $subtotal = get_converted_display_price($subtotal);
        $subtotal_with_currency = attachCurrencySymbol($subtotal);
        $data = ['cart_items' => $cart_items, 'total_items_count' => $count_items,'subtotal' => $subtotal, 'symbol' => $current_currency->symbol , 'subtotal_with_currency' => $subtotal_with_currency , 'currency_direction' => $current_currency->direction, 'currency_decimal' => $current_currency->decimal_places];
        $response = generateResponse($data,true,'',[],'collection');
        return $response;
    }
    public function store(Request $request){
      if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
       $customer = auth('customer-api')->user();
      }
      else{
        $customer = null;
      }
      //previous cart
      $session_token = $request->cookie('session_token');
      if($customer){
        $cart = $customer->cartItems()->where('is_ordered',0)->where('product_id',$request->product_id)->where('variant',$request->variant)->first();
      }
      else{
        $cart = Cart::where('session_token',$session_token)->where('is_ordered',0)->where('product_id',$request->product_id)->where('variant',$request->variant)->first();
      }
      //quantity to update
      if($cart){
        $quantity = $request->quantity + $cart->quantity;
      }else{
        $quantity = $request->quantity;
      }
      //stock
      $product = Product::find($request->product_id);
      if($product && $product->product_type == 2 && $request->variant){
        $variant = $product->variants()->where('variant',$request->variant)->first();
        if($variant){
          $stock = $variant->stock;
        }
        else{
          $stock = 0;
        }
      }
      else{
        $stock = $product->stock;
      }
      //update or create
      if($stock >= $quantity){
        if($quantity > $product->max_order){
          $message =  trans('messages.response.web.cannot_add_cart_product_exceeds');
          $response = generateResponse('',true,$message,[],'object');
          return $response;
        }
      if($cart){
          $cart->update(['quantity' => $quantity ]);
          $message =  trans('messages.response.web.already_in_cart');
          $response = generateResponse('',true,$message,[],'object');
          return $response;
      }
      if($customer){
        $cart = $customer->cartItems()->create(['product_id' => $request->product_id,'variant' => $request->variant, 'quantity' => $quantity]);
      }
      else{
        $cart = Cart::create(['product_id' => $request->product_id,'variant' => $request->variant, 'quantity' => $quantity, 'session_token' => $session_token]);
      }
      if($request->variant_attribute_value_names &&  count($request->variant_attribute_value_names) != 0){
          foreach ($request->variant_attribute_value_names as $variant_att_val_name) {
            $cart->attribute_value_names()->create(['attribute_name' => $variant_att_val_name['attribute_name'],'value_name' => $variant_att_val_name['value_name']]);
          }
      }
      $message =  trans('messages.response.web.added_to_cart_successfully');
      $response = generateResponse('',true,$message,[],'object');
      return $response;
    }
      else{
        $message =  trans('messages.response.web.out_of_stock_product');
        $response = generateResponse('',false,$message,[],'object');
        return $response;
      }
    }
    public function changeQuantity(Request $request){
      $stock_exceeds = [];
      $max_order_exceeds = [];
      foreach ($request->cart_items as  $item) {
        if(is_string($item)){
          $item = (array)json_decode($item);
        }
        $quantity = $item['quantity'];
        $cart = Cart::find($item['cart_id']);
        if($cart && $cart->product){
          if($cart->product->product_type == 2 && $cart->variant){
            $variant = $cart->product->variants()->where('variant',$cart->variant)->first();
            if($variant){
              $stock = $variant->stock;
            }
            else{
              $stock = 0;
            }
          }
          else{
            $stock = $cart->product->stock;
          }
          if($stock < $quantity ||  $quantity > $cart->product->max_order){
            if($stock < $quantity){
              $stock_exceeds[] = $cart->id;
              $message =  trans('messages.response.web.out_of_stock_product');
            }
            else if($quantity > $cart->product->max_order){
              $max_order_exceeds[] = $cart->id;
            }
          }
        }
      }
      if(count($stock_exceeds) == 0 && count($max_order_exceeds) == 0){
        foreach ($request->cart_items as $item) {
          if(is_string($item)){
            $item = (array)json_decode($item);
          }
          $cart = Cart::where('id',$item['cart_id'])->update(['quantity' => $item['quantity']]);
        }
        $message =  trans('messages.response.web.cart_successfully_updated');
        $response = generateResponse('',true,$message,[],'object');
      }
      else{
        $data = ['stock_exceeds' => $stock_exceeds,'max_order_exceeds' => $max_order_exceeds];
        $message = trans('messages.response.web.cart_cannot_updated');
        $response = generateResponse($data,false,$message,[],'object');
      }
      return $response;
    }
    public function destroy(Request $request,$cart_id){
        $cart = Cart::where('id',$cart_id)->first();
        if($cart){
          $cart->attribute_value_names()->delete();
          $cart->delete();
        }
        $data = ['message' => trans('messages.response.web.delete_from_cart')];
        return response()->json($data);
    }
    public function deleteAllCartItems(Request $request){
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $customer = auth('customer-api')->user();
            $cart_items = $customer->cartItems()->where('is_ordered',0)->get();
           }
           else{
             $customer = null;
             $session_token = $request->cookie('session_token');
             $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->whereNotNull('session_token')->get();
           }

          foreach ($cart_items as $item) {
            $item->attribute_value_names()->delete();
            $item->delete();
          }
          $message = trans('messages.response.web.items_deleted_from_cart');
          $response = generateResponse('',false,$message,[],'object');
          return $response;
    }
    public function validateCouponCode(ValidateCouponCodeRequest $request)
    {
        $coupon_exist= Coupon::withAll()->where('code', $request->coupon_code)->where('is_active',1)->first();

        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $customer = auth('customer-api')->user();
            $order_user = Order::where('coupon_code', $request->coupon_code)->where('customer_id',$customer->id)->get();
            $user_count = $order_user->count();
            if($coupon_exist)
            {
                $restricted_email_ids = $coupon_exist->email_restrictions->pluck('id');
                if(in_array($customer->id, $restricted_email_ids->toArray()))
                {
                    $message = trans('messages.response.web.cannot_use_coupon');
                    $response = generateResponse('',false,$message,[],'object');
                    return $response;
                }
            }
        }
        else
        {
            $message = trans('messages.response.web.login_to_use_coupon');;
            $response = generateResponse('',false,$message,[],'object');
            return $response;
        }

        $order_coupon = Order::where('coupon_code', $request->coupon_code)->get();
        $coupon_count= $order_coupon->count();
        // $coupon_exist= Coupon::withAll()->where('code', $request->coupon_code)->where('is_active',1)->first();

        if($coupon_exist)
        {

            if($coupon_exist->expiry_date <= now())
            {
                $message = trans('messages.response.web.coupon_has_expired');
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }

            elseif($coupon_exist->amount >= $request->order_amount)
            {
                $message = trans('messages.response.web.cart_amount_less_than_discount');;
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }
            elseif($request->order_amount < $coupon_exist->minimum_spend  )
            {
                $message = trans('messages.response.web.coupon_is_available_on_amount_between').$coupon_exist->minimum_spend . ' & ' . $coupon_exist->maximum_spend;
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }
            elseif($request->order_amount > $coupon_exist->maximum_spend)
            {
                $message = trans('messages.response.web.coupon_is_available_on_amount_between').$coupon_exist->minimum_spend . ' And ' . $coupon_exist->maximum_spend;
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }
            elseif($coupon_count >= $coupon_exist->usage_limit)
            {
                $message =  trans('messages.response.web.coupon_usage_limit_reached');
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }
            elseif($user_count >= $coupon_exist->user_limit)
            {
                $message = trans('messages.response.web.coupon_user_limit_reached');
                $response = generateResponse('',false,$message,[],'object');
                return $response;
            }
            else
            {
                $coupon_exist = new WebCouponsResource($coupon_exist);
                $response = generateResponse($coupon_exist,true,'',[],'object');
                return $response;
            }

        }
        else
        {
            $message =  trans('messages.response.web.coupon_not_available');
            $response = generateResponse('',false,$message,[],'object');
            return $response;
        }


    }
}
