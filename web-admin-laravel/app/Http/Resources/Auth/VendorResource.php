<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Vendor\VendorStoresResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'profile_image_path' => $this->profile_image_path,
            'verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'store' => new VendorStoresResource($this->store),
            'roles' => ['vendor'],
            'permissions' => []
        ];
    }
}
