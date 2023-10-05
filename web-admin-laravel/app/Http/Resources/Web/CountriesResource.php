<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CountriesResource extends JsonResource
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
            'is_active' => $this->is_active,
            'iso_code_2' => $this->iso_code_2,
            'iso_code_3' => $this->iso_code_3,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
