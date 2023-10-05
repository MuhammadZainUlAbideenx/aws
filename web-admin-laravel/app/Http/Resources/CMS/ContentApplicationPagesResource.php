<?php

namespace App\Http\Resources\CMS;
use App\Models\CMSModels\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContentApplicationPagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $allLanguages = allLanguages();
      $format = config('custom.date_format');
      return [
          'id' => $this->id,
          'name' => $this->name,
          'slug' => $this->slug,
          'nameTranslations' => $this->getTranslations('name'),
          'description' => $this->description,
          'descriptionTranslations' => $this->getTranslations('description'),
          'is_active'=> $this->is_active,
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
