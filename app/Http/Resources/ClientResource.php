<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * @var mixed
     */
    /**
     * @var mixed
     */

    /**
     * Transform the resource into an array.
     *
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'fullname'      => ucfirst($this->name) . ' ' . ucfirst($this->last_name),
            'email'         => $this->email,
            'business_name' => $this->clientInformation->business_name,
            'code'          => $this->clientInformation->code,
            'phone'         => $this->clientInformation->phone,
            'address'       => $this->clientInformation->address,
            'created_at'    => $this->created_at
        ];
    }
}
