<?php

namespace App\Http\Resources\Vendor;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CMS\RolesResource;
use App\Http\Resources\CMS\CountriesResource;
use App\Http\Resources\CMS\CitiesResource;
use App\Http\Resources\CMS\StatesResource;
use App\Http\Resources\CMS\VendorsResource;
use App\Models\User;
use App\Models\Vendor;

class RidersResource extends JsonResource
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
            'vendor' =>  new VendorsResource($this->whenLoaded('vendor')),
            'name' => $this->first_name.' '.$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'rider_type' => new RolesResource($this->whenLoaded('role')),
            'country' => new CountriesResource($this->whenLoaded('country')),
            'state' => new StatesResource($this->whenLoaded('state')),
            'city' => new CitiesResource($this->whenLoaded('city')),
            'zip_code' => $this->zip_code,
            'gender' => $this->gender,
            'dob_format' => date('d-m-Y', strtotime($this->dob)),
            'dob' => $this->dob,
            'phone' => $this->phone,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : '',
            'image' => new MediaResource($this->whenLoaded('image')),
      ];
    }
}
