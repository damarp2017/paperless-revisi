<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'price' => (int)$this->price,
            'discount_by_percent' => $this->discount_by_percent,
            'status' => (int)$this->status ? true : false,
            'category_id' => $this->category_id,
            'store_id' => $this->store_id
        ];
    }
}
