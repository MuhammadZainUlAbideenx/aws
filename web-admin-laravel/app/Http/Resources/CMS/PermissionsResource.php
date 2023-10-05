<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionsResource extends JsonResource
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
            'name'=>$this->name,
            'display_name' => $this->display_name,
            'display_nameTranslations' => $this->getTranslations('display_name'),
            'description' => $this->description,
            'descriptionTranslations' => $this->getTranslations('description'),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
      ];
    }
}
