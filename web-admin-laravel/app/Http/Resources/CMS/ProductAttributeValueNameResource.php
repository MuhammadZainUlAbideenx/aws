<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\Web\ProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeValueNameResource extends JsonResource
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
            'cart_id' => $this->cart_id,
            'order_product_id' => $this->order_product_id,
            'attribute_name' => $this->attribute_name,
            'value_name' => $this->value_name,
            ];
    }
}
