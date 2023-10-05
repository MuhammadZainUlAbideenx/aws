<?php

namespace App\Http\Resources\Vendor;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\CMS\ProductsResource;
use App\Http\Resources\CMS\ReviewStatusesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            'customer' => new CustomersResource($this->whenLoaded('customer')),
            'product' => new ProductsResource($this->whenLoaded('product')),
            'review' => new ReviewStatusesResource($this->whenLoaded('review_status')),
            'description' => $this->description,
            'rating' => $this->rating,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
