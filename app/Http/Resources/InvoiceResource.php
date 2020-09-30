<?php

namespace App\Http\Resources;

use App\OrderDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order_details = OrderDetail::where('order_id', $this->id)->get();
        $total_price = (array)null;

        foreach ($order_details as $item) {
            $total_price_each_item = $item->price * $item->quantity;
            $total_price[] =  $total_price_each_item;
        }

        return [
            'id' => $this->id,
            'discount' => $this->total_discount,
            'created_at' => $this->created_at,
            'total' => array_sum($total_price),
            'total_with_discount' => array_sum($total_price)-$this->total_discount,
            'order_details' => OrderDetailResource::collection($this->order_detail),
        ];
    }
}
