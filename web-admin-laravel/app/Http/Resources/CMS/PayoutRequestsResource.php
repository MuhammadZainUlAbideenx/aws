<?php

namespace App\Http\Resources\CMS;

use App\Http\Resources\Vendor\RidersResource;
use Illuminate\Http\Resources\Json\JsonResource;


class PayoutRequestsResource extends JsonResource
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
            'vendor' => new VendorsResource($this->whenLoaded('vendor')),
            'rider' => new RidersResource($this->whenLoaded('rider')),
            'display_amount' => attachCurrencyDecimal($this->amount),
            'amount' => $this->amount,
            'note' => $this->note,
            'status' => $this->status,
            'created_at' => $this->created_at ? $this->created_at->format($format) : ''
        ];
    }
}
