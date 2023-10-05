<?php

namespace App\Http\Resources\CMS;

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
        $format = config('custom.date_format');
        return [
            'id' => $this->id,
            'media_id' => $this->media_id,
            'thumbnail' => $this->thumbnail,
            'thumbnail_type' => $this->thumbnail_type,
            'height' => $this->height,
            'width' => $this->width,
            'media' => $this->media,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
