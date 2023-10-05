<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ThumbnailResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'thumbnail_type' => $this->thumbnail_type,
            'height' => $this->height,
            'width' => $this->width,
      ];
    }
}
