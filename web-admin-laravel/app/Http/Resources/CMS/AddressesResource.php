<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\CountriesResource;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\CMS\CitiesResource;
use App\Http\Resources\CMS\StatesResource;
use App\Http\Resources\UserResource;
use App\Models\User;

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
            'name' => $customer ? $customer->first_name.' '.$customer->last_name:'',
            'customer_id' => $this->customer_id,
            'country' => new CountriesResource($this->whenLoaded('country')),
            'state' => new StatesResource($this->whenLoaded('state')),
            'city' => new CitiesResource($this->whenLoaded('city')),
            'address' => $this->address,
            'near_by' => $this->near_by,
            'zip_code' => $this->zip_code,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
