<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveParentCategoriesResource extends JsonResource
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
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'image' => $this->image,
            'icon' => $this->icon,
            'image_thumbnail' => $this->image ? $this->image->thumbnails()->where('thumbnail_type','small')->first():null,
            'icon_thumbnail' => $this->icon ? $this->icon->thumbnails()->where('thumbnail_type','small')->first():null,
            'slug' => $this->slug,
            'childrens' => [],
            'parent' => $this->parent,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
