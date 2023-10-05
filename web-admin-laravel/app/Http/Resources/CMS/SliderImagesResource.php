<?php

namespace App\Http\Resources\CMS;
use App\Models\CMSModels\Media;
use App\Http\Resources\CMS\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
      $mediaImg = Media::where('id',$this->image)->first();
      $images = [];
      $allLanguages = allLanguages();
      $im_ids = $this->getTranslations('image');
      foreach ($allLanguages as $key => $value) {
        if(isset($im_ids[$value->code])){
          $media = Media::where('id',$im_ids[$value->code])->first();
          if($media){
            $media = $media->thumbnails()->where('thumbnail_type','small')->first();
            $media = $media->thumbnail;
          }
          else{
            $media = null;
          }
        }else{
          $media = null;
        }
        $images[$value->code] = $media;
      }
      $format = config('custom.date_format');
      return [
          'id' => $this->id,
          'image' => new MediaResource($mediaImg), //$mediaImg ? $mediaImg->thumbnails()->where('thumbnail_type','small')->first():null,
          'images' => $images,
          'imageTranslations' => $this->getTranslations('image'),
          'name' => $this->name,
          'nameTranslations' => $this->getTranslations('name'),
          'heading' => $this->heading,
          'headingTranslations' => $this->getTranslations('heading'),
          'button_text' => $this->button_text,
          'button_textTranslations' => $this->getTranslations('button_text'),
          'website_url' => $this->website_url,
          'url_type' => $this->url_type,
          'discount' => $this->discount,
          'slider_type' => $this->slider_type,
          'is_active'=> $this->is_active,
          'expiry_date' => $this->expiry_date,
          'expiry_date_index' => Carbon::parse($this->expiry_date)->format($format),
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
