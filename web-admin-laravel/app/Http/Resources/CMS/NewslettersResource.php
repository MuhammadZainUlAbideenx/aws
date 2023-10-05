<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class NewslettersResource extends JsonResource
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
            'email' => $this->email,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
