<?php

namespace App\Http\Resources\CMS;
use Illuminate\Http\Resources\Json\JsonResource;
class InventoriesResource extends JsonResource
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
          'stock' => $this->stock,
          'purchase_price' => $this->purchase_price,
          'reference_number' => $this->reference_number,
          'stock_type' => $this->stock_type,
      ];
    }
}
