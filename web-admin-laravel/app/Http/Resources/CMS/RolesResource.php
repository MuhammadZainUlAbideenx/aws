<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\CMS\PermissionsResource;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
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
            'display_name' => $this->display_name,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'permissions' => PermissionsResource::collection($this->permissions()->get()),
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
