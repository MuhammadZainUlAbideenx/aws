<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            'image' => new MediaResource($this->whenLoaded('image')),
            'icon' => new MediaResource($this->whenLoaded('icon')),
            'slug' => $this->slug,
            'childrens' => CategoriesResource::collection($this->whenLoaded('childrens')),
            'min_price' => $this->when(isset($this->min_price),attachCurrencyDecimal($this->min_price))
            // 'parent' => new CategoriesResource($this->whenLoaded('parent')),
        ];
    }
}
