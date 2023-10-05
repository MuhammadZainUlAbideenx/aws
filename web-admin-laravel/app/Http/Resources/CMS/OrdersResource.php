<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\PaymentMethodsSimpleResource;
use App\Http\Resources\CMS\OrderStatusesResource;
use App\Http\Resources\Vendor\RidersResource;
use App\Http\Resources\Web\CustomerResource;
use App\Models\CMSModels\Currency;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\OrderStatus;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currency = Currency::where('code', $this->current_currency)->first();
        $format = config('custom.date_format');
        $addresses = $this->relationLoaded('order_addresses') ? $this->whenLoaded('order_addresses'):null;
        $vendor_addresses = $this->relationLoaded('vendor_order_addresses') ? $this->whenLoaded('vendor_order_addresses'):null;
        if ($addresses && count($addresses) > 0) {
            $addresses = OrderAddressesResource::collection($addresses)->keyBy('address_type');
        }
        if ($vendor_addresses && count($vendor_addresses) > 0) {
            $addresses = OrderAddressesResource::collection($vendor_addresses)->keyBy('address_type');
        }

        // order products saved in aon variable
        $order_products = $this->relationLoaded('order_products') ? $this->whenLoaded('order_products'):null;
        $vendor_order_products = $this->relationLoaded('vendor_order_products') ? $this->whenLoaded('vendor_order_products'):null;
        if ($order_products && count($order_products) > 0) {
            $order_products = OrderProductsResource::collection($order_products);
        }
        if ($vendor_order_products && count($vendor_order_products) > 0) {
            $order_products = OrderProductsResource::collection($vendor_order_products);
        }
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'order_status' => new OrderStatusesResource($this->whenLoaded('order_status')),
            'rider' => new RidersResource($this->whenLoaded('rider')),
            'order_status_reason' => $this->order_status_reason,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            //  'addresses' => $this->whenLoaded('order_addresses'),
            'order_products' => $order_products,
            // 'vendor_order_products' => $order_products,
            'number' => $this->order_number,
            'addresses' => $addresses,
            'vendor' => new VendorsResource($this->whenLoaded('vendor')),
            'shipping_method' => $this->whenLoaded('shipping_method'),
            'payment_method' => $this->whenLoaded('payment_method'),
            'transaction_id' => $this->transaction_id,
            'transaction_status' => $this->transaction_status,
            'total' => attachCurrencyDecimal($this->total),
            'order_time_currency_display_total' => get_display_price_with_currency($currency, $this->current_currency_total),
            'current_currency_value' => $this->current_currency_value,
            'current_currency_total' => $this->current_currency_total,
            'order_time_currency_display_sub_total_1' => get_display_price_with_currency($currency, $this->current_currency_sub_total),
            'order_time_currency_shipping_price_1' => get_display_price_with_currency($currency, $this->current_currency_shipping_price),
            'is_paid' => $this->is_paid,
            'sub_total' => attachCurrencyDecimal($this->sub_total),
            'order_time_currency_display_sub_total' => get_display_price_with_currency($currency, $this->sub_total),
            'shipping_price' => attachCurrencyDecimal($this->shipping_price),
            'order_time_currency_display_shipping_price' => get_display_price_with_currency($currency, $this->shipping_price),
            'order_time_currency_display_coupon_amount' => get_display_price_with_currency($currency, $this->coupon_amount),
            'payment_method' => $this->payment_method->code,
            'coupon_amount' => attachCurrencyDecimal($this->coupon_amount),
            'is_active' => $this->is_active,
            'sub_order' => $this->when(isset($this->sub_order),function () {
                return $this->sub_order;
              }),
            'sub_order_detail' => $this->when(isset($this->order),function () {
                return $this->order;
              }),
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
