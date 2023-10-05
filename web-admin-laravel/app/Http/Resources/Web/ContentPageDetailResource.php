<?php

namespace App\Http\Resources\Web;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentPageDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $seo  = $this->whenLoaded('seo');
      $seo = $seo ? $seo : [
        'title' => strip_tags($this->name),
        'description' => strip_tags($this->description),
        'keywords' => '',
        'meta_tags' => [],
      ];
      return [
          'id' => $this->id,
          'name' => $this->name,
          'slug' => $this->slug,
          'description' => strip_tags($this->description),
          'description_web' => $this->description,
          'seo' => $seo,
        ];
    }
}
