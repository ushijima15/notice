<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeForList extends JsonResource
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
            'full_name' => $this->full_name,
            'full_phonetic_name' => $this->full_phonetic_name,
            'is_admin' => isset($this->user) ? $this->user->is_admin : false,
            'is_leader' => isset($this->user) ? $this->user->is_leader : false,
        ];
    }
}
