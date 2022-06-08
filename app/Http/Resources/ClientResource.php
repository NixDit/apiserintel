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
            'id'                    => $this->id,
            'fullname'              => ucfirst($this->name) . ' ' . ucfirst($this->last_name),
            'email'                 => $this->email,
            'client_information'    => $this->clientInformation,
            'routes'                => $this->routes,
            'created_at'            => $this->created_at
        ];
    }
}
