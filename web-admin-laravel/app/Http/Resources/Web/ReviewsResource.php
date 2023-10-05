<?php

namespace App\Http\Resources\Web;
use App\Http\Resources\CMS\CustomersResource;
use App\Http\Resources\Web\ProductsResource;
use Carbon\Carbon;
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
            'description' => $this->description,
            "customer_id"=> $this->customer_id,
            "product_id"=> $this->product_id,
            "order_id"=>$this->order_id,
            "is_active"=> $this->is_active,
            "review_status_id"=> $this->review_status_id,
            "images_url"=> json_decode($this->images_url),
            'rating' => $this->rating,
            'created_at' => Carbon::parse($this->created_at)->format('d, M, Y'),

      ];
    }
}
