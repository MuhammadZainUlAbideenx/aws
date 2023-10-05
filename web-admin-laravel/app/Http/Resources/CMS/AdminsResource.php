<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CMS\RolesResource;
use App\Http\Resources\CMS\CountriesResource;
use App\Http\Resources\CMS\CitiesResource;
use App\Http\Resources\CMS\StatesResource;
use App\Models\User;

class AdminsResource extends JsonResource
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
            'name' => $this->first_name.' '.$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'admin_type' => new RolesResource($this->whenLoaded('role')),
            'email' => $this->email,
            'country' => new CountriesResource($this->whenLoaded('country')),
            'state' => new StatesResource($this->whenLoaded('state')),
            'city' => new CitiesResource($this->whenLoaded('city')),
            'zip_code' => $this->zip_code,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
