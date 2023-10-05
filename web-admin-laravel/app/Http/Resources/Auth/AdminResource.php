<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        $role = $this->roles->pluck('name')->toArray();
        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'email' => $this->email,
            'verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'profile_image_path' => $this->profile_image_path,
            'roles' => $role ? $role:[$this->role->name],
            'permissions' => $this->allPermissions()->pluck('name')->toArray()
        ];
    }
}
