<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\ProductCategoriesResource;
use App\Http\Resources\Web\FlashSaleResource;
use App\Http\Resources\Web\ProductMediaResource;

use Carbon\Carbon;



class SearchProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product_variants = $this->relationLoaded('variants')? ProductVariantsResource::collection($this->whenLoaded('variants')): null;
        $min_price = $product_variants ? $product_variants->where('product_id', $this->id)->min('price'):null;
        $current_currency = session('current_currency');
      $now = Carbon::now();
      $tags = [];
      if($this->is_feature){
        $tags[] = 'Featured';
      }
      if($this->relationLoaded('flash_sale')){
        $flash_sale = $this->whenLoaded('flash_sale');
        if($flash_sale && $flash_sale->start_date <= Carbon::now()->toISOString() &&
            $flash_sale->expire_date >= Carbon::now()->toISOString() &&
            $flash_sale->is_active == 1
          ){
            $tags[] = 'on Sale';
            $flash_sale = new FlashSaleResource($flash_sale);
        }
        else{
          $flash_sale = null;
        }
      }
      else{
        $flash_sale = null;
      }
     if(!$flash_sale && $this->relationLoaded('special_sale')){
        $special_sale = $this->whenLoaded('special_sale');
        if($special_sale &&
            $special_sale->expire_date >= Carbon::now()->toISOString() &&
            $special_sale->is_active == 1
          ){
            $tags[] = 'on Sale';
            $special_sale = new SpecialSaleResource($special_sale);
        }
        else{
          $special_sale = null;
        }
      }
      else{
        $special_sale = null;
      }
      if($this->available_date > Carbon::now()->subDays(20)->toISOString()
        ){
          $tags[] = 'New';
      }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tags' => $tags,
            'short_description' => strip_tags($this->short_description),
            'sku'=> $this->sku,
            'modal' => $this->modal,
            'product_type' => $this->product_type,
            'display_price' => get_display_price($this->price),
            'price' => $this->converted_price,
            'starting_from_price' => get_display_price($min_price)  ? get_display_price($min_price) : null,
            'stock' => $this->stock,
            'is_available' => $this->available_date <= Carbon::now()->toISOString() ? true:false,
            'is_variable' => count($product_variants)>0 ? true:false,
            'variants' =>$product_variants,
            'product_type' => $this->product_type,
            'slug' => $this->slug,
            'flash_sale' => $flash_sale,
            'special_sale' => $special_sale,
            'categories'=> ProductCategoriesResource::collection($this->whenLoaded('categories',function(){
                return $this->categories->where('parent_id',0);
              })
            )->category_ids($this->category_ids),
            'media' => ProductMediaResource::collection($this->whenLoaded('media')),
            'reviews_average_rating' => $this->whenLoaded('reviews',function() {
                                      if($this->reviews->where('review_status_id',5)->count() > 0){
                                        return round($this->reviews->where('review_status_id',5)->sum('rating') / $this->reviews->where('review_status_id',5)->count());
                                      }
                                      else{
                                        return 0;
                                      }

                              })
        ];
    }
}
