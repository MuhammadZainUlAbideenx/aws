<?php

namespace App\Http\Resources\Vendor;

use App\Http\Resources\Auth\CustomerResource;
use App\Http\Resources\Web\OrderProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\PaymentMethodsSimpleResource;
use App\Http\Resources\Web\OrderStatusesResource;
use App\Models\CMSModels\Currency;
use App\Models\CMSModels\Order;

class SalesOrdersResource extends JsonResource
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

        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'number' => $this->order_number,
            'transaction_id' => $this->transaction_id,
            'transaction_status' => $this->transaction_status,
            'total' => $this->total,
            'order_time_currency_display_total' =>  $this->current_currency_total,
            'current_currency_value' => $this->current_currency_value,
            'current_currency_total' => $this->current_currency_total,
            'current_currency_sub_total' => $this->current_currency_sub_total,
            'order_time_currency_shipping_price_1' => $this->current_currency_shipping_price,
            'is_paid' => $this->is_paid,
            'sub_total' => $this->sub_total,
            'order_time_currency_display_sub_total' => $this->sub_total,
            'order_time_currency_display_shipping_price' => $this->shipping_price,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at
        ];
    }
}
