<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorCategoryResource extends JsonResource
{
    public function toArray($request)
    {
      return [
          'categories' => CategoriesResource::collection($this->whenLoaded('categories')),
        ];
    }
}
