<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Vendor\RidersResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\OrderStatusesResource;
use App\Http\Resources\Web\VendorsResource;
use App\Models\CMSModels\Currency;

class SubOrdersResource extends JsonResource
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
        $current_currency = session('current_currency');
        // manage order products code starts
        $order_products = $this->relationLoaded('order_products') ? $this->whenLoaded('order_products') : null;

        $vendor_order_products = $this->relationLoaded('vendor_order_products') ? $this->whenLoaded('vendor_order_products') : null;


        if ($order_products && count($order_products) > 0) {
            $order_products = $order_products->where('order_id',(int)$this->parent_order_id)->where('vendor_id',$this->vendor_id);
            $product_details = OrderProductsResource::collection($order_products);
        }
       else if ($vendor_order_products && count($vendor_order_products) > 0) {
           $vendor_order_products = $vendor_order_products->where('order_id',(int)$this->parent_order_id)->where('vendor_id',$this->vendor_id);

            $product_details = OrderProductsResource::collection($vendor_order_products);
        }
        else{
            $product_details = null;
        }
        // manage order products code ends

        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'order_products' => $product_details,
            'number' => $this->order_number,
            'payment_method' => new PaymentMethodsResource($this->whenLoaded('payment_method')),
            'order_time_currency_display_sub_total_1' => get_display_price_with_currency($currency, $this->current_currency_sub_total),
            'order_time_currency_shipping_price_1' => get_display_price_with_currency($currency, $this->current_currency_shipping_price),
            'order_time_currency_display_total' => get_display_price_with_currency($currency, $this->current_currency_total),
            'vendor' => new VendorsResource($this->whenLoaded('vendor')),
            'rider' => new RidersResource($this->whenLoaded('rider')),
            'order_status' => new OrderStatusesResource($this->whenLoaded('order_status')),
            'order_status_reason' => $this->order_status_reason,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : '',
            'discount_amount' => $this->coupon_amount ? $this->coupon_amount : '',
        ];
    }
}
