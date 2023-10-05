<?php

namespace App\Http\Resources\Web;
use App\Http\Resources\CMS\CountriesResource;
use App\Http\Resources\CMS\ZonesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StatesResource extends JsonResource
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
            'country' => new CountriesResource($this->whenLoaded('countries')),
            'zone' => new ZonesResource($this->whenLoaded('zone')),
            'code' => $this->code,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
