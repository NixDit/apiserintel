<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleCollection extends JsonResource
{

    public static $wrap = 'sales';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'client'        => $this->costumer->clientInformation->business_name,
            'subtotal'      => $this->subtotal,
            'total'         => $this->total,
            'status'        => $this->status,
            'folio'         => $this->folio,
            'created_at'    => $this->created_at->format('d-m-Y')
        ];
    }
}
