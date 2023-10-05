<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class CommissionCategoriesResource extends JsonResource
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
          'id' => $this->id,
          'category_id' => $this->category_id,
          'rate' => $this->rate,
          'rate_type' => $this->rate_type,
          'commission_min_amount_fixed' => $this->commission_min_amount_fixed
      ];
    }
}
