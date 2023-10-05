<?php

namespace App\Http\Resources\Web;
use App\Models\CMSModels\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class ParallaxBannersResource extends JsonResource
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
            'image' => new MediaResource($mediaImg),
            'name' => $this->name,
            'button_text' => $this->button_text,
            'description' => $this->description,
            'website_url' => $this->website_url,
            'expiry_date' => $this->expiry_date,
            'url_type' => $this->url_type,
      ];
    }
}
