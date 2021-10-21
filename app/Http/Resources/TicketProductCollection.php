<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketProductCollection extends JsonResource
{
    public static $wrap = 'product';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'          => $this->name,
            'price'         => $this->retail_price,
            'quantity'      => $this->pivot->quantity,
            'subtotal'      => $this->pivot->subtotal,
            'total'         => $this->pivot->total,
        ];
    }
}
