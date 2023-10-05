<?php

namespace App\Http\Resources\Web;

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
        return [
          'id' => $this->id,
          'name' => $this->name,
          'address' => $this->address,
          'latitude' => $this->latitude,
            'longitude' => $this->longitude,
          'cover_image' => new MediaResource($this->whenLoaded('cover_image')),
          'store_logo' => new MediaResource($this->whenLoaded('store_logo')),
          'city' => $this->whenLoaded('city',function(){
                    return $this->city->name;
          }),
          'country' => $this->whenLoaded('country',function(){
                      return $this->country->name;
          }),
          'state' => $this->whenLoaded('state',function(){
                    return $this->state->name;
          }),
          'phone' => $this->phone,
          'slug' => $this->slug,
          'postal_code' => $this->postal_code,
          'headline' => $this->headline,
          'description' => $this->description,
          'is_active' => $this->is_active,
          'updated_at' => $this->updated_at,
        ];
    }
}
