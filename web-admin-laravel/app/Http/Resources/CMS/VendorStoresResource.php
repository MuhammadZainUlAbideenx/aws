<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorStoresResource extends JsonResource
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
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'cover_image' => new MediaResource($this->cover_image),
            'logo_image' => new MediaResource($this->store_logo),
            'city' => $this->city,
            'country' => $this->country,
            'state' => $this->state,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'headline' => $this->headline,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
