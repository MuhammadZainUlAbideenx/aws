<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\MediaResource;
use App\Http\Resources\CMS\ParentCategoryResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $seo  = $this->seo ? $this->seo : [
        'title' => strip_tags($this->name),
        'description' => strip_tags($this->description),
        'keywords' => '',
        'meta_tags' => [],
      ];
      $format = config('custom.date_format');
      return [
          'id' => $this->id,
          'name' => $this->name,
          'nameTranslations' => $this->getTranslations('name'),
          'description' => $this->description,
          'descriptionTranslations' => $this->getTranslations('description'),
          'image' =>  new MediaResource($this->whenLoaded('image')),
          'icon' => new MediaResource($this->whenLoaded('icon')),
          //'image_thumbnail' => $this->image ? $this->image->thumbnails()->where('thumbnail_type','small')->first():null,
        //  'icon_thumbnail' => $this->icon ? $this->icon->thumbnails()->where('thumbnail_type','small')->first():null,
          'slug' => $this->slug,
          'childrens' => CategoriesResource::collection($this->whenLoaded('childrens')),
          'parent' => new ParentCategoryResource($this->whenLoaded('parent')),
          'seo' => $seo,
          'is_active' => $this->is_active,
          'is_featured' => $this->is_featured,
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
