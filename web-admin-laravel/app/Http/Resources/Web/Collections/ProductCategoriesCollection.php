<?php

namespace App\Http\Resources\Web\Collections;
use App\Http\Resources\Web\ProductCategoriesResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCategoriesCollection extends AnonymousResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     protected $category_ids;

     public function category_ids($value){
         $this->category_ids = $value;
         return $this;
     }

    public function toArray($request)
    {
      return $this->collection->map(function(ProductCategoriesResource $resource) use($request){
          return $resource->category_ids($this->category_ids)->toArray($request);
        })->all();
    }
}
