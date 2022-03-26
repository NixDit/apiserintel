<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'created_at'    => $this->created_at
        ];
    }
}
