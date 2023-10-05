<?php

namespace App\Http\Resources\Web;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\Web\ProductsResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewsResource extends JsonResource
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
            'description' => $this->description,
            'rating' => $this->rating,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'review_status_id' => $this->review_status_id,
            'created_at' => Carbon::parse($this->created_at)->format($format),
            'product'=> new ProductsResource($this->product),
            "images_url"=> json_decode($this->images_url),
      ];
    }
}
