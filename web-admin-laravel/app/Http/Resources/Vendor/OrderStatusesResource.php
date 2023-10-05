<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusesResource extends JsonResource
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
            'name' => $this->name,
            'nameTranslations' => $this->getTranslations('name'),
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
