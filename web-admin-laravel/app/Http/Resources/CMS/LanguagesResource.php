<?php

namespace App\Http\Resources\CMS;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguagesResource extends JsonResource
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
          'name' => $this->name,
          'code' => $this->code,
          'direction' => $this->direction,
          'is_default' => $this->is_default,
          'image_id' => $this->image_id,
          'is_active' => $this->is_active,
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''

      ];
    }
}
