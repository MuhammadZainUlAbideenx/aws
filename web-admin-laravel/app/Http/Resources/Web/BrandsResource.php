<?php

namespace App\Http\Resources\Web;
use App\Http\Resources\CMS\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsResource extends JsonResource
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
            'image' => new MediaResource($this->whenLoaded('image')),
            'description' => $this->description,
            'website_url' => $this->website_url,
            'is_active' => $this->is_active,
        ];
    }
}
