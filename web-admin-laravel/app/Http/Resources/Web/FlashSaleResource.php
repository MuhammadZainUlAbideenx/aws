<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;


class FlashSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'display_price' => get_display_price($this->product_price),
            'price' => $this->converted_price,
            'currency' => $this->current_currency,
            'default_currency' => $this->default_currency,
            'default_currency_price' => $this->default_currency_price,
            'conversion_rate' => $this->currency_conversion_rate,
            'start_date' => $this->start_date,
            'expire_date' => $this->expire_date,
            'is_active' => $this->is_active,
            'product_price' => $this->product_price
        ];
    }
}
