<?php

namespace App\Http\Resources\CMS;
use App\Models\CMSModels\Brand;
use App\Http\Resources\CMS\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BrandsResource extends JsonResource
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
            'image' => new MediaResource($this->whenLoaded('image')),
          //  'thumbnail' => $this->image ? $this->image->thumbnails()->where('thumbnail_type','small')->first():null,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'website_url' => $this->website_url,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format($format) : ''
        ];
    }
}
