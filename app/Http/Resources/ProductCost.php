<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCost extends JsonResource
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
            'display_state' => $this->display_state,
            'producted_on' => $this->producted_on->format('Y-m-d'),
            'item_name' => $this->finished_on->format('Y-m-d'),
            
        ];
    }
}
