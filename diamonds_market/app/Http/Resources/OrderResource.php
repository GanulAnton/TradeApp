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
            'user_id' => $this->user_id,
            'diamond_quantity' => $this->diamond_quantity,
            'usd_quantity' => $this->usd_quantity,
            'life_time' => $this->life_time,
            'rate' => $this->rate,
            'order_type' => $this->order_type,
        ];
    }
}
