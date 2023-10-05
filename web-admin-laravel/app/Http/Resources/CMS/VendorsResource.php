<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $format = config('custom.date_format');
        return [
            'id' => $this->id,
            'categories'=>$this->category_ids,
            'display_categories' => CategoriesResource::collection($this->whenLoaded('categories')),
            'profile_image' => new MediaResource($this->profile_image),
            'products' => $this->whenLoaded('products'),
            'contact_phone' => $this->contact_phone,
            'email' => $this->email,
            'name' => $this->name,
            'store_details' => new VendorStoresResource($this->whenLoaded('store')),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
