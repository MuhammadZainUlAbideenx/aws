<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentCategoryResource extends JsonResource
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
          'nameTranslations' => $this->getTranslations('name'),
          'description' => $this->description,
          'descriptionTranslations' => $this->getTranslations('description'),
          'slug' => $this->slug,
          'media' => $this->whenLoaded('image'),
          'icon' => $this->whenLoaded('icon'),
        ];
    }
}
