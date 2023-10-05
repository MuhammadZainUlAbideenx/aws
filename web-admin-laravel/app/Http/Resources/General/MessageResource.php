<?php

namespace App\Http\Resources\General;
use App\Http\Resources\Vendor\RidersResource;
use App\Http\Resources\Web\VendorsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'rider' => new RidersResource($this->whenLoaded('rider')),
            'user_detail' => $this->whenLoaded($this->user_type),
            'order_number' => $this->order_number,
            'vendor'=> new VendorsResource($this->whenLoaded('vendor')),
            'user_type' => $this->user_type,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
            'updated_at' => $this->updated_at,
        ];
    }
}
