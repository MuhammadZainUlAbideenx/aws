<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\ThumbnailResource;
class ProductMediaResource extends JsonResource
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
            'name' => $this->name,
            'original_media_path' => $this->original_media_path,
            'type' => $this->type,
            'mime_type' => $this->mime_type,
            'thumbnails' => ThumbnailResource::collection($this->whenLoaded('thumbnails'))->keyBy('thumbnail_type'),
            'sort_order' => $this->whenPivotLoaded('product_media', function () {
                              return $this->pivot->sort_order;
                            }),
            'description' => $this->whenPivotLoaded('product_media', function () {
                              return $this->pivot->description;
                            }),
            'alt_text' => $this->whenPivotLoaded('product_media', function () {
                              return $this->pivot->description;
                            }),
      ];
    }
}
