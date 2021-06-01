<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeForShow extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'first_phonetic_name' => $this->first_phonetic_name,
            'last_phonetic_name' => $this->last_phonetic_name,
            'user_name' => isset($this->user) ? $this->user->name : null,
            'is_admin' => isset($this->user) ? $this->user->is_admin : false,
            'is_leader' => isset($this->user) ? $this->user->is_leader : false,
        ];
    }
}
