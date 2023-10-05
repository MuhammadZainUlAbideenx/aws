<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // if(isset($this->latest_post)){
        //     dd("posts of ", $this->latest_post);
        // }
        $latest_posts =  $this->when(isset($this->latest_posts), function () {
            return $this->latest_posts;
        });

      $format = config('custom.date_format');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => $this->user->first_name.' '.$this->user->last_name,
            'image' => new MediaResource($this->whenLoaded('image')),
            'slug' => $this->slug,
            'news_category' => new NewsCategoriesResource($this->whenLoaded('news_category')),
            'description' => strip_tags($this->description),
            'description_web' => $this->description,
            'is_featured' => $this->is_featured,
            'latest_posts' => NewsesResource::collection($latest_posts),
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
