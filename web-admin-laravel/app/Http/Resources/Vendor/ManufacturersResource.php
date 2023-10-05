<?php

namespace App\Http\Resources\Vendor;
use App\Models\CMSModels\Manufacturer;
use App\Http\Resources\CMS\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturersResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'website_url' => $this->website_url,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
