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
            'own_like_good'=>$this->like->where('user_id', Auth::user()->id)->where('reaction_no',1)->count(),
            'own_like_heart'=>$this->like->where('user_id', Auth::user()->id)->where('reaction_no',2)->count(),
            'own_like_check'=>$this->like->where('user_id', Auth::user()->id)->where('reaction_no',3)->count(),
            'count_good'=>$this->like->where('reaction_no',1)->count(),
            'count_heart'=>$this->like->where('reaction_no',2)->count(),
            'count_check'=>$this->like->where('reaction_no',3)->count(),
            'comment_visusal'=>false,
        ];
    }
}
