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
        $types = ['Prepago', 'Pagado', 'Postpago'];

        return [
            'id'            => $this->id,
            'client'        => $this->customer->clientInformation->business_name,
            'subtotal'      => $this->subtotal,
            'total'         => $this->total,
            'type'         =>  $types[$this->type - 1],
            'status'        => $this->status,
            'folio'         => $this->folio,
            'created_at'    => $this->created_at->format('d-m-Y')
        ];
    }
}
