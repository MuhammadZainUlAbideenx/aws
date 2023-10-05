<?php

namespace App\Http\Resources\Web;
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
            'answer' => strip_tags($this->answer),
            'answer_web' => $this->answer,

            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
