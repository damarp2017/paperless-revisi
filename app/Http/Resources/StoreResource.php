<?php

namespace App\Http\Resources;

use App\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'owner' => [
                'id' => $this->owner->id,
                'name' => $this->owner->name
            ],
            'employee' => EmployeeResource::collection($this->employee),
            'code' => $this->code,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'store_logo' => $this->store_logo,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
