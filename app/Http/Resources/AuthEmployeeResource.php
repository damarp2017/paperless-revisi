<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'api_token' => $this->api_token,
            'username' => $this->username,
            'role' => $this->role,
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
            ],
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
