<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\CMS\MediaResource;

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
            'nameTranslations' => $this->getTranslations('name'),
            'image' => new MediaResource($this->image),
            // 'thumbnail' => $this->image ? $this->image->thumbnails()->where('thumbnail_type','small')->first():null,
            'slug' => $this->slug,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
