<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\ManufacturersResource;
use App\Http\Resources\CMS\TaxClassesResource;
use App\Http\Resources\CMS\UnitsResource;
use App\Http\Resources\CMS\MediaResource;
use App\Http\Resources\Web\FlashSaleResource;
use App\Http\Resources\Web\SpecialSaleResource;
use App\Models\CMSModels\Media;
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
        $current_currency = session('current_currency');
      $seo  = $this->seo ? $this->seo : [
        'title' => strip_tags($this->name),
        'description' => strip_tags($this->description),
        'meta_tags' => [],
        'keywords' => ''
      ];
      $format = config('custom.date_format');
       //   sale price shown and flash sale price shows at admin panel.
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
      if($this->product_type == 1)
      {
        $final_stock = $this->stock;
      }
      elseif($this->product_type == 2)
      {

        $final_stock = $this->whenLoaded('variants',function() {
            return $this->variants->sum('stock');
          });
      }else
      {
        $final_stock = 0;
      }
      return [
          'id' => $this->id,
          'attributes' => ProductAttributesResource::collection($this->whenLoaded('attributes'))->product_id($this->id),
          'variants' => $this->whenLoaded('variants'),
          'vendor' => $this->whenLoaded('vendor'),
          'name' => $this->name,
          'nameTranslations' => $this->getTranslations('name'),
          'short_description' => $this->short_description,
          'description' => $this->description,
          'refund_policy' => $this->refund_policy,
          'sku' => $this->sku,
          'shortDescriptionTranslations' => $this->getTranslations('short_description'),
          'descriptionTranslations' => $this->getTranslations('description'),
          'refundPolicyTranslations' => $this->getTranslations('refund_policy'),
          'product_type' => $this->product_type,
          'modal' => $this->modal,
          'shipping_weight' => $this->shipping_weight,
          'price' => $this->price,
          'display_price' => attachCurrencyDecimal($this->price),
          'starting_from_price' => attachCurrencyDecimal($min_price)  ? attachCurrencyDecimal($min_price) : null,
          'stock' => $final_stock,
          'quantity' => $this->quantity,
          'available_date' => $this->available_date,
          'weight' => $this->weight,
          'unit' => new UnitsResource($this->whenLoaded('unit')),
          'media' => $this->whenLoaded('media'),
        //  'thumbnails' => MediaResource::collection($this->media),
          'is_active' => $this->is_active,
          'is_feature' => $this->is_feature,
          'manufacturer' => new ManufacturersResource($this->whenLoaded('manufacturer')),
          'brand' => new BrandsResource($this->whenLoaded('brand')),
          'tax_class' =>  new TaxClassesResource($this->whenLoaded('tax_class')),
          'product_ordered' => $this->product_ordered,
          'product_liked' => $this->product_liked,
          'slug' => $this->slug,
          'external_link' => $this->external_link,
          'max_order' => $this->max_order,
          'seo' => $this->LoadMissing('seo'),
          'faq' => FaqsResource::collection($this->whenLoaded('faqs')),
          'min_order' => $this->min_order,
          'flash_sale' => $flash_sale,
          'special_sale' => $special_sale,
          'categories'=>$this->category_ids,
          'categories_res' =>  CategoriesResource::collection($this->whenLoaded('categories')),
          'related_products' => ProductsResource::collection($this->whenLoaded('related_products')),
          'related_products_without_all' => ProductsResource::collection($this->whenLoaded('related_products_without_all')),
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
