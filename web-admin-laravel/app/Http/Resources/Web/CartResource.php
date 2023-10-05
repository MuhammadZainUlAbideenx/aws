<?php

namespace App\Http\Resources\Web;
use App\Http\Resources\Web\ProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CMSModels\Currency;


class CartResource extends JsonResource
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
      $current_currency = session('current_currency');
      $default_currency = session('default_currency');
      $us_currency = Currency::where('code' , 'USD')->orWhere('code' , 'usd')->first();
      // if we do not collect then it will check to real product model not from product resource return data thats why first collect and then apply LogicException
      // if logic matches then we can get pr dd("New Product", $product);
      $FilteredProduct = collect($product);
      if($product['product_type'] == 2 && $this->variant){
          $variant = $this->variants()->where('product_id',$this->product_id)->first();
          $stock = $variant->stock;
        $single_default_price_without_sale = $variant->price;
        $single_current_price_without_sale = $variant->price * $current_currency->value;
        $single_usd_price_without_sale = $variant->price * $us_currency->value;
        $single_default_price_float = $variant->price;
        $single_current_price_float = $variant->price * $current_currency->value;
        $single_usd_price_float = $variant->price *  $us_currency->value;

        $single_price = get_display_price($variant->price);
        $price = $this->quantity * $variant->price;
        $display_price = get_display_price($price);
      }
      else{
        $stock = $product->stock;

        if($FilteredProduct['flash_sale']){
          $single_price = get_display_price($product->flash_sale->product_price);

          $single_default_price_without_sale = $product->price;
          $single_current_price_without_sale = $product->price * $current_currency->value;
          $single_usd_price_without_sale = $product->price * $us_currency->value;
          $single_default_price_float = $product->flash_sale->product_price;
          $single_current_price_float = $product->flash_sale->product_price * $current_currency->value;
          $single_usd_price_float = $product->flash_sale->product_price *  $us_currency->value;

          $price = $this->quantity * $product->flash_sale->product_price;
          $display_price = get_display_price($price);
        }
        else if($FilteredProduct['special_sale']){

          $single_price = get_display_price($product->special_sale->special_price);

          $single_default_price_without_sale = $product->price;
          $single_current_price_without_sale = $product->price * $current_currency->value;
          $single_usd_price_without_sale = $product->price * $us_currency->value;
          $single_default_price_float = $product->special_sale->special_price;
          $single_current_price_float = $product->special_sale->special_price * $current_currency->value;
          $single_usd_price_float = $product->special_sale->special_price *  $us_currency->value;

          $price = $this->quantity * $product->special_sale->special_price;
          $display_price = get_display_price($price);
        }
          else{
          $single_price = get_display_price($product->price);

          $single_default_price_without_sale = $product->price;
          $single_current_price_without_sale = $product->price * $current_currency->value;
          $single_usd_price_without_sale = $product->price * $us_currency->value;
          $single_default_price_float = $product->price;
          $single_current_price_float = $product->price* $current_currency->value;
          $single_usd_price_float = $product->price *  $us_currency->value;

          $price = $this->quantity * $product->price;
          $display_price = get_display_price($price);
        }

    }
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'product' => $product,
            'attribute_value_names' => CartAttributeValueNameResource::collection($this->whenLoaded('attribute_value_names')),
            'price' => get_converted_price($price),
            'single_price' => $single_price,
            'display_price' => $display_price,
            'variant' => $this->variant,
            'stock' =>$stock,
            'default_price' => get_price($price),
            'single_default_price_without_sale' => $single_default_price_without_sale,
            'single_default_price_without_sale_web' => get_display_price($single_default_price_without_sale),
            'single_current_price_without_sale' => $single_current_price_without_sale,
            'single_usd_price_without_sale' => $single_usd_price_without_sale,
            'single_default_price_float' => $single_default_price_float,
            'single_current_price_float' => $single_current_price_float,
            'single_usd_price_float' => $single_usd_price_float,
            'currency' => get_current_currency_code(),
            'default_currency' => get_default_currency_code(),
        ];
    }
}
