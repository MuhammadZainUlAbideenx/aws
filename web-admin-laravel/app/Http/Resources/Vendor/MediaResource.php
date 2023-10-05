<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\ThumbnailResource;

class MediaResource extends JsonResource
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
            'original_media_path' => $this->original_media_path,
            'width'=> $this->width,
            'height'=> $this->height,
            'type' => $this->type,
            'mime_type' => $this->mime_type,
            'thumbnails' => ThumbnailResource::collection($this->thumbnails)->keyBy('thumbnail_type'),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
