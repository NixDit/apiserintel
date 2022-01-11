<?php

namespace App\Http\Resources;

use App\Http\Resources\TicketProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketProductsResource extends JsonResource
{

    public static $wrap = 'products';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'client'        => $this->customer->clientInformation->business_name,
            'seller'        => $this->seller->name . ' #' . $this->seller->id,
            'subtotal'      => $this->subtotal,
            'total'         => $this->total,
            'folio'         => $this->folio,
            'products'      => TicketProductCollection::collection( $this->products ),
            'created_at'    => $this->created_at->format('d/m/Y h:i A')
        ];
    }
}
