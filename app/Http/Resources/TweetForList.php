<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
class TweetForList extends JsonResource
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
            'text' => $this->text,
            'user_id' => $this->user_id,
            'user_name' =>$this->user->name,
            'own_like'=>$this->like->where('user_id', Auth::user()->id)->count(),
            'count'=>$this->like->count(),
            'comment_visusal'=>false,
        ];
    }
}
