<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsByCategoriesResource extends JsonResource
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
            'products' => ProductsResource::collection($this->whenLoaded('products')),
            'slug' => $this->slug,
        ];
    }
}
