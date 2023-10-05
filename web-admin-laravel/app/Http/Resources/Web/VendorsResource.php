<?php

namespace App\Http\Resources\Web;

use App\Models\CMSModels\Order;
use App\Models\CMSModels\Review;
use Illuminate\Http\Resources\Json\JsonResource;


class VendorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $reviews_average_rating = null;
        $products = $this->relationLoaded('products') ? $this->whenLoaded('products'):[];
        if ($products) {
            $product_ids = $products->pluck('id');
            $reviews = Review::whereIn('product_id', $product_ids)->get();
            if ($reviews->count() > 0) {
                $reviews_average_rating = $reviews->sum('rating') / $reviews->count();
            }
            else
            {
                $reviews_average_rating = null;
            }
        }
        if ($this->relationLoaded('followers')) {
            # code...
            $total_followers = count($this->whenLoaded('followers')->where('vendor_id', $this->id));
            $is_followed = auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer') && count($this->whenLoaded('followers')->where('vendor_id', $this->id)->where('customer_id',auth('customer-api')->user()->id)) > 0 ? true : false;
        }
        else
        {
            $total_followers = 0;
            $is_followed = false;
        }
        $orders = Order::where('vendor_id',$this->id)->get();
        $completed_orders = Order::where('vendor_id',$this->id)->where('order_status_id',7)->get();
        if ( $orders->count() > 0) {
            $total_deliver_order = $completed_orders->count() / $orders->count();
            $orders_average_rating = round($total_deliver_order * 5);
        }
        else
        {
            $orders_average_rating = null;
        }

        return [
            'id' => $this->id,
            'products' =>ProductsResource::collection($products),
            'email' => $this->email,
            'name' => $this->name,
            'slug' => $this->slug,
            'contact_phone' => $this->contact_phone,
            'reviews_average_rating' => $reviews_average_rating ? $reviews_average_rating: 0,
            'orders_average_rating' => $orders_average_rating ? $orders_average_rating: 0,
            'profile_image' => new MediaResource($this->whenLoaded('profile_image')),
            'profile_image_url' => $this->profile_image_path,
            'store' => new VendorStoresResource($this->whenLoaded('store')),
            'total_follower' => $total_followers,
            'is_followed' => $is_followed,
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
        ];
    }
}
