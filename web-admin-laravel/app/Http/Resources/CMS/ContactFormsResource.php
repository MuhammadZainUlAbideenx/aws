<?php

namespace App\Http\Resources\CMS;
use App\Models\CMSModels\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContactFormsResource extends JsonResource
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
          'email' => $this->email,
          'subject' => $this->subject,
          'message' => $this->message,
          'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
