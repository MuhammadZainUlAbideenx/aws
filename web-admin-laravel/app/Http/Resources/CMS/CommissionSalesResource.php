<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class CommissionSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'to_sale' => $this->to_sale,
          'from_sale' => $this->from_sale,
          'duration' => $this->duration,
          'rate' => $this->rate,
          'rate_type' => $this->rate_type,
      ];
    }
}
