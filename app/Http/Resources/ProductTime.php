<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTime extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'product_cost_id' => $this->product_cost_id,
            'started_on' => $this->started_on,
            'finished_on' => $this->finished_on,
            'employee_id' => isset($this->employee_id) ? $this->employee_id : '',
            'employee_name' => isset($this->employee_id) ? $this->employee->full_name : '',
        ];
    }
}
