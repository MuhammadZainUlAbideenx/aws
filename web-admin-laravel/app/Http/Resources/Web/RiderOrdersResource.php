<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\OrderStatusesResource;
use App\Http\Resources\Web\VendorsResource;
use App\Http\Resources\Web\CouponsResource;
use App\Models\CMSModels\Currency;

class RiderOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $rider = auth()->user();
        $currency = Currency::where('code', $this->current_currency)->first();
        $format = config('custom.date_format');
        $current_currency = session('current_currency');
        // manage order products code starts
        if($this->parent_order_id == 0)
        {
            $order_id = $this->id;
        }
        else
        {
            $order_id = $this->parent_order_id;
        }
        $order_products = $this->relationLoaded('order_products') ? $this->whenLoaded('order_products')->where('vendor_id', $rider->vendor_id)->where('order_id',$order_id) : null;
        $vendor_order_products = $this->relationLoaded('vendor_order_products') ? $this->whenLoaded('vendor_order_products')->where('vendor_id', $rider->vendor_id)->where('order_id', $order_id) : null;
        if ($order_products && count($order_products) > 0) {
            $product_details = OrderProductsResource::collection($order_products);
        }
       else if ($vendor_order_products && count($vendor_order_products) > 0) {
            $product_details = OrderProductsResource::collection($vendor_order_products);
        }
        else{
            $product_details = null;
        }

        // manage order products code ends

        $order_addresses = $this->relationLoaded('order_addresses') ? $this->whenLoaded('order_addresses')->keyBy('address_type'): null;
        $vendor_order_addresses = $this->relationLoaded('vendor_order_addresses') ? $this->whenLoaded('vendor_order_addresses')->keyBy('address_type') : null;
        if ($order_addresses && count($order_addresses) > 0) {
            $order_addresses_detail = OrderAddressesResource::collection($order_addresses);
        }
       else if ($vendor_order_addresses && count($vendor_order_addresses) > 0) {
            $order_addresses_detail = OrderAddressesResource::collection($vendor_order_addresses);
        }
        else{
            $order_addresses_detail = null;
        }


        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'order_status' => new OrderStatusesResource($this->whenLoaded('order_status')),
            'order_status_reason' => $this->order_status_reason,
            'coupon' => new CouponsResource($this->whenLoaded('coupon')),
            'order_products' => $product_details,
            // 'vendor_order_products' => $product_details,
            'number' => $this->order_number,
            'addresses' => $order_addresses_detail,
            'shipping_method' => $this->whenLoaded('shipping_method'),
            'payment_method' => $this->whenLoaded('payment_method'),
            'vendor' => new VendorsResource($this->whenLoaded('vendor')),
            'customer' => $this->whenLoaded('customer'),
            'rider' => $this->whenLoaded('rider'),
            'transaction_id' => $this->transaction_id,
            'transaction_status' => $this->transaction_status,
            'total' => $this->total,
            'currency_symbol' => $current_currency->symbol,
            'current_currency_sub_total' => $this->current_currency_sub_total,
            'current_currency_shipping_price' => $this->current_currency_shipping_price,
            'current_currency_value' => $this->current_currency_value,
            'order_time_currency_display_sub_total_1' => get_display_price_with_currency($currency, $this->current_currency_sub_total),
            'order_time_currency_shipping_price_1' => get_display_price_with_currency($currency, $this->current_currency_shipping_price),
            'order_time_currency_display_total' => get_display_price_with_currency($currency, $this->current_currency_total),
            'is_paid' => $this->is_paid,
            'sub_total' => $this->sub_total,
            'sub_order' => $this->when(isset($this->sub_order),function () {
                return $this->sub_order;
              }),
            'sub_order_detail' => $this->when(isset($this->order),function () {
                return $this->order;
              }),
            'order_time_currency_display_sub_total' => get_display_price_with_currency($currency, $this->sub_total),
            'shipping_price' => $this->shipping_price,
            'order_time_currency_display_shipping_price' => get_display_price_with_currency($currency, $this->shipping_price),
            'payment_method' => $this->payment_method->code,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : '',
            'discount_amount' => $this->coupon_amount ? $this->coupon_amount : '',
            'discount_amount_with_currency' => $this->coupon_amount ? attachCurrencyDecimal($this->coupon_amount) : '',
        ];
    }
}
