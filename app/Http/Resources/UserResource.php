<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'                 => $this->email,
            'status'                => $this->status,
            'phone'                 => $this->phone,
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'full_name'             => $this->fullName,
            'role'                  => $this->role,
            'date_of_birth'         => $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : null,
            'timezone'              => $this->timezone,

            // dates
            'email_verified_at'     => eclair($this->email_verified_at),
            'email_verified_at_w3c' => eclair($this->email_verified_at, true, true),
            'phone_verified_at'     => eclair($this->phone_verified_at),
            'phone_verified_at_w3c' => eclair($this->phone_verified_at, true, true),
            'last_login_at'         => eclair($this->last_login_at),
            'last_login_at_w3c'     => eclair($this->last_login_at, true, true),
            'created_at'            => eclair($this->created_at),
            'created_at_w3c'        => eclair($this->created_at, true, true),
            'updated_at'            => eclair($this->updated_at),
            'updated_at_w3c'        => eclair($this->updated_at, true, true),
            'verified_at'           => eclair($this->verified_at),
            'verified_at_w3c'       => eclair($this->verified_at, true, true),

            // links
            'avatar_url'           => $this->avatar_url,

        ];
    }
}
