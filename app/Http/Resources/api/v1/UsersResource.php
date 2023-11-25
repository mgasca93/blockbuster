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
            'firstnam'      => $this->firstname,
            'lastname'      => $this->lastname,
            'fullname'      => $this->firstname . ' ' . $this->lastname,
            'slug'          => $this->slug,
            'e-mail'        => $this->email,
            'created_at'    => $this->created_at->diffForHumans(),
            'rol'           => $this->getRoleNames()->first()
        ];
    }
}
