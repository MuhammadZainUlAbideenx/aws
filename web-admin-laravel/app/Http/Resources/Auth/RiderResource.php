<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Web\CitiesResource;
use App\Http\Resources\Web\CountriesResource;
use App\Http\Resources\Web\MediaResource;
use App\Http\Resources\Web\StatesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RiderResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'store' => $this->store,
            'country' => new CountriesResource($this->country),
            'state' => new StatesResource($this->state),
            'city' => new CitiesResource($this->city),
            'image' => $this->profile_image_path,
            'roles' => ['rider'],
            'permissions' => []
        ];
    }
}
