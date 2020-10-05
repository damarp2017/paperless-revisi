<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchasementResource extends JsonResource
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
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
            ],
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'date' => $this->date,
        ];
    }
}
