<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EmployeeForSelector as EmployeeForSelectorResource;
use App\Http\Resources\Interruption as InterruptionResource;
use Illuminate\Support\Facades\Auth;

class ProductCostResume extends JsonResource
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
            // todo
            'employee_id' => isset(Auth::user()->employee) ? Auth::user()->employee->id : null,
            'is_finished' => $this->is_finished,
            'updated_at' => $this->updated_at->format('Y-m-d G:i:s'),
            'state' => json_decode($this->state),
            'workers' => EmployeeForSelectorResource::collection($this->employees),
        ];
    }
}
