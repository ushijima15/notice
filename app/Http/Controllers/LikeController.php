<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    //コンポーネント初期読み込み時(created)に呼び出される
    public function firstcheck($employee) {
        $user = Auth::user();
        $likes = new Like();
        $like = Like::where('employees_id',$employee)->where('user_id',$user->id)->first();
        if($like) {
             $count = $likes->where('employees_id',$employee)->where('like',1)->count();
             return [$like->like,$count];
        } else {
             $like = $likes->create([
                  'user_id' => $user->id,
                  'employees_id' => $employee,
                  'like' => 0
             ]);
             $count = $likes->where('employees_id',$employee)->where('like',1)->count();
             return [$like->like,$count];
        }
    }
   
       //いいねボタンを押した時に呼び出される
       public function check($employee) {
        $user = Auth::user();
        $likes = new Like();
        $like = Like::where('employees_id',$employee)->where('user_id',$user->id)->first();
        if($like->like == 1) {
             $like->like = 0;
             $like->save();
             $count = $likes->where('employees_id',$employee)->where('like',1)->count();
             return [$like->like,$count];
        } else {
             $like->like = 1;
             $like->save();
             $count = $likes->where('employees_id',$employee)->where('like',1)->count();
             return [$like->like,$count];
        };
    }
}
