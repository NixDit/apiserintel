<?php

namespace App\Http\Resources;

use App\Http\Resources\CreditPaymentsCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PrepaidPurchasesCollection extends JsonResource
{

    public static $wrap = 'sales';


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'folio'         => $this->folio,
            'total'         => $this->credit->total,
            'payments'      => CreditPaymentsCollection::collection( $this->credit->payments ),
            'created_at'    => $this->created_at->format('d-m-Y')
        ];
    }
}



