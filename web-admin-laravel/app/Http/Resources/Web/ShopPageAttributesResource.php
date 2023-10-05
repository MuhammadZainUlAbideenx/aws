<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopPageAttributesResource extends JsonResource
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
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'values' => ShopPageAttributeValuesResource::collection($this->whenLoaded('values',function(){
                          return $this->values->where('name','!=','')->where('slug','!=','')->unique(function($item){
                              return strtoupper($item->name);
                          })->unique('slug');
            })),
        ];
    }
}
