<?php

namespace App\Http\Resources\Web;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturersResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'website_url' => $this->website_url,
        ];
    }
}
