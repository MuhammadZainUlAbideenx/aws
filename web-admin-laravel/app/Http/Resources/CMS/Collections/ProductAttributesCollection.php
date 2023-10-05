<?php

namespace App\Http\Resources\CMS\Collections;
use App\Http\Resources\CMS\ProductAttributesResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductAttributesCollection extends AnonymousResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     protected $product_id;

     public function product_id($value){
         $this->product_id = $value;
         return $this;
     }

    public function toArray($request)
    {
      return $this->collection->map(function(ProductAttributesResource $resource) use($request){
          return $resource->product_id($this->product_id)->toArray($request);
        })->all();
    }
}
