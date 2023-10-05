<?php

namespace App\Http\Resources\Web;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\ProductsResource;

class CouponsResource extends JsonResource
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
            'vendor' => $this->whenLoaded('vendor'),
            'code' => $this->code,
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'discount_type' => $this->discount_type,
            'amount' => $this->amount,
            'amount_with_currency' => get_display_price($this->amount),
            'expiry_date' => $this->expiry_date,
            'minimum_spend' => $this->minimum_spend,
            'maximum_spend' => $this->maximum_spend,
            'minimum_spend_with_currency' => attachCurrencyDecimal($this->minimum_spend),
            'maximum_spend_with_currency' => attachCurrencyDecimal($this->maximum_spend),
            'products' => ProductsResource::collection($this->whenLoaded('products')),
            'productsIds' => $this->products()->get()->pluck('id'),
            'categories' => $this->whenLoaded('categories'),
            'categoriesIds' => $this->categories()->get()->pluck('id'),
            'email_restrictions' => $this->email_restrictions()->get()->pluck('id'),
            'usage_limit' => $this->usage_limit,
            'user_limit' => $this->user_limit,
            'free_shipping' => $this->free_shipping,
            'individual_use' => $this->individual_use,
            'exclude_sale_items' => $this->exclude_sale_items,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
