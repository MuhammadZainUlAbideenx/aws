<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\CMS\TaxClassesResource;

use Illuminate\Http\Resources\Json\JsonResource;


class TaxRatesResource extends JsonResource
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
            'rate' => $this->rate,
            'zone' => $this->whenLoaded('zone'),
            'is_active' => $this->is_active,
            'tax_class' => new TaxClassesResource($this->whenLoaded('tax_class')),
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
