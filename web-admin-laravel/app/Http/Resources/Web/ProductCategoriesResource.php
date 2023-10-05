<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\Collections\ProductCategoriesCollection;
class ProductCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'image' => new MediaResource($this->whenLoaded('image')) ?? null,
            'icon' => new MediaResource($this->whenLoaded('icon')) ?? null,
            'childrens' => ProductCategoriesResource::collection($this->whenLoaded('childrens',function(){
                          return $this->childrens->whereIn('id',$this->category_ids);
            })),
            'slug' => $this->slug,
        ];
    }
    public static function collection($resource){
        return new ProductCategoriesCollection($resource,get_called_class());
    }
}
