<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitsResource extends JsonResource
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
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
