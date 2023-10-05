<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Vendor\Collections\ProductAttributesCollection;

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
        $format = config('custom.date_format');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nameTranslations' => $this->getTranslations('name'),
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'values' => ProductAttributeValuesResource::collection($this->whenLoaded('values',function(){
                          return $this->values->where('product_id',$this->product_id);
            })),
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }

    public static function collection($resource){
        return new ProductAttributesCollection($resource,get_called_class());
    }
}
