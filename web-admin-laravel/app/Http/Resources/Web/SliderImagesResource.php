<?php

namespace App\Http\Resources\Web;
use App\Models\CMSModels\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $mediaImg = Media::where('id',$this->image)->withAll()->first();
      return [
          'id' => $this->id,
          'name' => $this->name,
          'heading' => $this->heading,
          'button_text' => $this->button_text,
          'discount' => $this->discount,
          'website_url' => $this->website_url,
          'image' => new MediaResource($mediaImg),
          'slider_type' => $this->slider_type,
          'expiry_date' => $this->expiry_date,
          'url_type' => $this->url_type,

      ];
    }
}
