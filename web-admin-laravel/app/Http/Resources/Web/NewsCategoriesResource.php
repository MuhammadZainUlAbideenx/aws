<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsCategoriesResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->whenLoaded('image'),
            'slug' => $this->slug,
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
