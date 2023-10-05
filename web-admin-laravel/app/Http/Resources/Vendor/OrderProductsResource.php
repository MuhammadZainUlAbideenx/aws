<?php

namespace App\Http\Resources\Vendor;

use App\Http\Resources\CMS\ProductAttributeValueNameResource;
use App\Http\Resources\Web\ProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CMSModels\Currency;


class OrderProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    public function toArray($request)
    {
          $product =  new ProductsResource($this->whenLoaded('product'));
          $order = $this->order()->first();
          $currency = Currency::where('code' , $order->current_currency)->first();
          if($this->sale_price_current){
            $product_order_time_sale_display_price = get_display_price_with_currency($currency,$this->sale_price_current);
            $current_product_order_time_total_sale_display_price = get_display_price_with_currency($currency,$this->total_sale_price_current);
          }else{
            $product_order_time_sale_display_price = '';
            $current_product_order_time_total_sale_display_price = '';
          }

      return [
          'id' => $this->id,
          'quantity' => $this->quantity,
          'product' => $product,
          'current_product_order_time_display_price' => get_display_price_with_currency($currency,$this->single_price_current),
          'order_product_variant_details' => ProductAttributeValueNameResource::collection($this->whenLoaded('order_product_variant_details')),
          'sale_type' => $this->sale_type,
          'sale_price_current' => $this->sale_price_current,
          'total_sale_price_current' => $this->total_sale_price_current,
          'current_product_order_time_total_sale_display_price' => $current_product_order_time_total_sale_display_price,
          'product_order_time_sale_display_price' => $product_order_time_sale_display_price,
          'single_price_current' => $this->single_price_current,
          'total_price_current' => $this->total_price_current,
          'current_product_order_time_total_display_price' =>  get_display_price_with_currency($currency,$this->total_price_current),
          'single_price_default' => $this->single_price_default,
          'total_price_default' => $this->total_price_default,
      ];
    }
  }
