<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSlimResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    =>  (int) $this->id,
            'name'                  => $this->name,
            'aka'                   => $this->aka,
            'email'                 => $this->email,
            'full_name'             => $this->full_name,
            'phone'                 => $this->phone,
            'status'                => $this->status,

            // relationships
            'role'                  => $this->role,

            // links
            'avatar_url'           => $this->avatar_url,
        ];
    }
}
