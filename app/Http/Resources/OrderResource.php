<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total_price' => $this->total_price,
            'total_discount' => $this->total_discount,
            'total_price_with_discount' => $this->total_price_with_discount,
            'order_details' => OrderDetailResource::collection($this->order_detail),
        ];
    }
}
