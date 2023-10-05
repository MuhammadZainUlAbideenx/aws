<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\Collections\ProductAttributesCollection;

class ProductAttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'values' => ProductAttributeValuesResource::collection($this->whenLoaded('values',function(){
                          return $this->values->where('product_id',$this->product_id);
            })),
            'is_active' => $this->is_active,
        ];
    }
    public static function collection($resource){
        return new ProductAttributesCollection($resource,get_called_class());
    }
}
