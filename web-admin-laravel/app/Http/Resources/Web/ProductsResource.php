<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\CMS\FaqsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\ProductCategoriesResource;
use App\Http\Resources\Web\ManufacturersResource;
use App\Http\Resources\Web\FlashSaleResource;
use App\Http\Resources\Web\ProductMediaResource;
use App\Http\Resources\Web\ProductVendorsResource;
use App\Models\CMSModels\ProductVariant;
use Carbon\Carbon;



class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $min_price = ProductVariant::where('product_id',$this->id)->min('price');
        $vendor = $this->relationLoaded('vendor') ? new ProductVendorsResource($this->whenLoaded('vendor')) : null;
        if ($vendor) {
            $vendor['reviews_average_rating'] =  $this->when(isset($this->reviews_average_rating), function () {
                return $this->reviews_average_rating;
            });
        }
        $current_currency = session('current_currency');
        $now = Carbon::now();
        $seo  = $this->seo;
        $seo = $seo ? [
            'title' => $seo->title,
            'description' => $seo->description,
            'meta_tags' => $seo->meta_tags,
            'keywords' => $seo->keywords
        ] : [
            'title' => strip_tags($this->name),
            'description' => strip_tags($this->description),
            'meta_tags' => [],
            'keywords' => ''
        ];
        $tags = [];
        if ($this->is_feature) {
            $tags[] = 'Featured';
        }
        if ($this->relationLoaded('flash_sale')) {
            $flash_sale = $this->whenLoaded('flash_sale');
            if (
                $flash_sale && $flash_sale->start_date <= Carbon::now()->toISOString() &&
                $flash_sale->expire_date >= Carbon::now()->toISOString() &&
                $flash_sale->is_active == 1
            ) {
                $tags[] = 'on Sale';
                $flash_sale = new FlashSaleResource($flash_sale);
            } else {
                $flash_sale = null;
            }
        } else {
            $flash_sale = null;
        }
        if (!$flash_sale && $this->relationLoaded('special_sale')) {
            $special_sale = $this->whenLoaded('special_sale');
            if (
                $special_sale &&
                $special_sale->expire_date >= Carbon::now()->toISOString() &&
                $special_sale->is_active == 1
            ) {
                $tags[] = 'on Sale';
                $special_sale = new SpecialSaleResource($special_sale);
            } else {
                $special_sale = null;
            }
        } else {
            $special_sale = null;
        }
        if (
            $this->available_date > Carbon::now()->subDays(20)->toISOString()
        ) {
            $tags[] = 'New';
        }
        return [
            'id' => $this->id,
            'attributes' => ProductAttributesResource::collection($this->whenLoaded('attributes'))->product_id($this->id),
           'variants' => ProductVariantsResource::collection($this->whenLoaded('variants')),
            'name' => $this->name,
            'tags' => $tags,
            'short_description' => strip_tags($this->short_description),
            'description' => strip_tags($this->description),
            'refund_policy' => strip_tags($this->refund_policy),
            'short_description_web' => $this->short_description,
            'description_web' => $this->description,
            'refund_policy_web' => $this->refund_policy,
            'product_type' => $this->product_type,
            'sku' => $this->sku,
            'brand' => new BrandsResource($this->whenLoaded('brand')),
            'modal' => $this->modal,
            'display_price' => get_display_price($this->price),
            'price' => $this->converted_price,
            'starting_from_price' => get_display_price($min_price)  ? get_display_price($min_price) : null,
            'currency' => $this->current_currency,
            'default_currency' => $this->default_currency,
            'default_price' => $this->default_price,
            'conversion_rate' => $this->currency_conversion_rate,
            'currency_symbol' => $current_currency->symbol,
            'stock' => $this->stock,
            'available_date' => Carbon::parse($this->available_date)->format('Y-m-d H:i:A'),
            'is_available' => $this->available_date <= Carbon::now()->toISOString() ? true : false,
            'is_upcoming' => $this->available_date <= Carbon::now()->toISOString() ? false : true,
            //    'date_diff' => $now->lte($this->available_date),
            //    'now' => $now,
            //    'timezone' => $now->timezone,
            'weight' => $this->weight,
            'unit' => $this->whenLoaded('unit')->name ?? null,
            'media' => ProductMediaResource::collection($this->whenLoaded('media')),
            'manufacturer' => new ManufacturersResource($this->whenLoaded('manufacturer')),
            'tax_class' => new TaxClassesResource($this->whenLoaded('tax_class')),
            'vendor' => $vendor,

            'product_ordered' => $this->product_ordered,
            'product_liked' => $this->product_liked,
            'slug' => $this->slug,
            'external_link' => $this->external_link,
            'max_order' => $this->max_order,
            'min_order' => $this->min_order,
            'faq' => FaqsResource::collection($this->whenLoaded('faqs')),
            'flash_sale' => $flash_sale,
            'special_sale' => $special_sale,
            'is_wishlisted' => auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer') && count(auth('customer-api')->user()->wishlistProducts()->where('products.id', $this->id)->get()) > 0 ? true : false,
            'categories' => ProductCategoriesResource::collection(
                $this->whenLoaded('categories', function () {
                    return $this->categories->where('parent_id', 0);
                })
            )->category_ids($this->category_ids),
            'seo' => $seo,
            'reviews' => ProductReviewsResource::collection($this->whenLoaded(
                'reviews',
                function () {
                    return $this->reviews->where('review_status_id', 5);
                }
            )),
            'total_reviews' => $this->whenLoaded('reviews', function () {
                return $this->reviews->where('review_status_id', 5)->count();
            }),
            'reviews_average_rating' => $this->whenLoaded('reviews', function () {
                if ($this->reviews->where('review_status_id', 5)->count() > 0) {
                    return $this->reviews->where('review_status_id', 5)->sum('rating') / $this->reviews->where('review_status_id', 5)->count();
                } else {
                    return 0;
                }
            })

        ];
    }
}
