<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CMS\ProductsResource;
use App\Http\Resources\CMS\CategoriesResource;
use App\Http\Resources\CMS\ContentPagesResource;

class SeoPagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      if($this->product_id){
        $seo_type_text = 'Product';
        $seo_type = 'product';
      }
      else if($this->category_id){
        $seo_type_text = 'Category';
        $seo_type = 'category';
      }
      else if($this->content_page_id){
        $seo_type_text = 'Content Page';
        $seo_type = 'content_page';
      }
      else if($this->static_page_id){
        $seo_type_text = 'Static Page';
        $seo_type = 'static_page';
      }
      else{
        $seo_type_text= '';
        $seo_type= '';
      }
      $format = config('custom.date_format');
      return [
          'seo' => [
              'id' => $this->id,
              'title' => $this->title,
              'description' => $this->description,
              'keywords' => $this->keywords,
              'meta_tags'=> $this->meta_tags,
              'seo_type' => $seo_type,
              'static_page_id' => $this->static_page_id,
              'product' => new ProductsResource($this->whenLoaded('product')),
              'category' => new CategoriesResource($this->whenLoaded('category')),
              'content_page' => new ContentPagesResource($this->whenLoaded('content_page')),
              'seo_type_text' => $seo_type_text,
              'created_at' => $this->created_at ? $this->created_at->format($format) : ''
              ]
            ];
        }
}
