<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\CMS\CountriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonesResource extends JsonResource
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
            'is_active' => $this->is_active,
            'code' => $this->code,
            'country' => new CountriesResource($this->whenLoaded('countries')),
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
