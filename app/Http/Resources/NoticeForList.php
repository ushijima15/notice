<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
class NoticeForList extends JsonResource
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
            'tweet_id'=>$this->tweet_id,
            'tweet_userid' => $this->tweet_userid,
            'tweet_username'=>$this->tweet->user->name,
            'comment_userid'=>$this->user_id,
            'comment_username'=>$this->user->name,
        ];
    }
}
