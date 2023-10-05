<?php

namespace App\Http\Resources\Vendor;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductAttributeValuesResource extends JsonResource
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
          'name' => $this->name,
          'nameTranslations' => $this->getTranslations('name'),
          'value' => $this->getTranslations('name'),
          'attribute_id' => $this->attribute_id,
          'slug' => $this->slug,
          'product_id' => $this->product_id,
      ];
    }
}
