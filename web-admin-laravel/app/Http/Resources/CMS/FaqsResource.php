<?php

namespace App\Http\Resources\CMS;
use App\Http\Resources\CMS\MediaResource;
use App\Http\Resources\CMS\ProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqsResource extends JsonResource
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
            'question' => $this->question,
            'questionTranslations' => $this->getTranslations('question'),
            'answer' => $this->answer,
            'answerTranslations' => $this->getTranslations('answer'),
            'product' => new ProductsResource($this->whenLoaded('product')),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
