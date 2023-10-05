<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantsResource extends JsonResource
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
          'price' => get_converted_price($this->price),
          'display_price' => get_display_price($this->price),
          'currency' => get_current_currency_code(),
          'default_currency' => get_default_currency_code(),
          'default_price' => get_price($this->price),
          'variant' => $this->variant,
          'stock' => $this->stock,
          'sku' => $this->sku,
        ];
    }
}
