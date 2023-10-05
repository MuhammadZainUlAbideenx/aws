<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'first_name'=> $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'profile_image_path' => $this->profile_image_path,
            'verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'roles' => ['customer'],
            'permissions' => []
        ];
    }
}
