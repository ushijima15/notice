<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EmployeeForSelector as EmployeeForSelectorResource;

class ProductCostForList extends JsonResource
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
            'worked_on' => $this->worked_on,
            // todo
            
            'display_state' => $this->display_state,
            'is_finished' => $this->is_finished,
        ];
    }
}
