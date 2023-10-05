<?php

namespace App\Http\Resources\Web;

use App\Models\CMSModels\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVendorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $orders = Order::where('vendor_id',$this->id)->get();
        $completed_orders = Order::where('vendor_id',$this->id)->where('order_status_id',7)->get();
        if ($orders->count() > 0) {
            $total_deliver_order = $completed_orders->count() / $orders->count();
        }
        else
        {
            $total_deliver_order = 0;
        }
        $orders_average_rating = round($total_deliver_order * 5);
        // dd($this->reviews_average_rating);
        return [
          'id' => $this->id,
          'email' => $this->email,
          'name' => $this->name,
          'slug' => $this->slug,
          'contact_phone' => $this->contact_phone,
          'reviews_average_rating' => $this->when(isset($this->reviews_average_rating),function () {
            return $this->reviews_average_rating;
          }),
          'orders_average_rating' => $orders_average_rating,
          'profile_image' => new MediaResource($this->whenLoaded('profile_image')),
          'store' => new VendorStoresResource($this->whenLoaded('store')),
          'products' => ProductsResource::collection($this->whenLoaded('products')),
          'is_active' => $this->is_active,
          'updated_at' => $this->updated_at,
        ];
    }
}
