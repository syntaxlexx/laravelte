<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => (int) $this->id,
            'user_id'           => $this->user_id,
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'subject'           => $this->subject,
            'body'              => $this->body,
            'ip_address'        => $this->ip_address,

            // dates
            'created_at'        => eclair($this->created_at),
            'created_at_w3c'    => eclair($this->created_at, true, true),

            //
            'user'              => new UserSlimResource($this->whenLoaded('user')),

            $this->mergeWhen(doe()->isAdmin, function() {
                return [
                    'site_domain'       => $this->site_domain,
                    'last_read_at'      => eclair($this->last_read_at),
                    'last_read_at_w3c'  => eclair($this->last_read_at, true, true),
                ];
            }),
        ];
    }
}
