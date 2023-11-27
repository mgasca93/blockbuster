<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'fullname'      => $this->fullName,
            'slug'          => $this->slug,
            'url_unique'    => $request->root() . '/api/v1/users/' . $this->slug,
            'e-mail'        => $this->email,
            'status'        => $this->estatus,
            'created_at'    => $this->created_at->diffForHumans(),
            'rol'           => $this->getRoleNames()->first()
        ];
    }
}
