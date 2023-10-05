<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\CountriesResource;
use App\Http\Resources\Web\CitiesResource;
use App\Http\Resources\Web\StatesResource;
class AddressesResource extends JsonResource
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
        $customer = $this->whenLoaded('customer');
        return [
            'id' => $this->id,
            'country' => new CountriesResource($this->whenLoaded('country')),
            'state' => new StatesResource($this->whenLoaded('state')),
            'city' => new CitiesResource($this->whenLoaded('city')),
            'address' => $this->address,
            'near_by' => $this->near_by,
            'is_default' => $this->is_default,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
      ];
    }
}
