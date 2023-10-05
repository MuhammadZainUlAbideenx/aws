<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\AddressesResource;
use App\Http\Resources\Web\CountriesResource;
use App\Http\Resources\Web\CitiesResource;
use App\Http\Resources\Web\StatesResource;

class CustomerResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->first_name.' '.$this->last_name,
            'email' => $this->email,
            'gender' => $this->gender,
            'profile_image_path' => $this->profile_image_path,
          //  'addresses' => AddressesResource::collection($this->addresses),
          //  'shipping_address' => new AddressesResource($this->shipping_address),
        //    'billing_address' => new AddressesResource($this->billing_address),
            'dob' => $this->dob,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
