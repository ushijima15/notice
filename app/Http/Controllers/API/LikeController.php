<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\LikeForList as LikeForListResource;
use App\Http\Resources\LikeForShow as LikeForShowResource;
use App\Http\Resources\LikeForSelector as LikeForSelectorResource;
use App\Like;
use App\Tweet;
use App\User;
class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$post = Post::find($id);
        //$post->users()->attach(Auth::id());
        // $post = Employee::find($id);
        // $post->users()->attach(Auth::id());
        return 123;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // $post = Employee::find($id);
        // $post->users()->attach(Auth::id());
        $post->user_id = Auth::id();
        $like = new Test;
        $like->id = $request->like['id'];
        $like->tweet_id = $request->like['tweet_id'];
        $like->user_id = Auth::id();
        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //$post = Post::find($id);
        //$post->users()->attach(Auth::id());
        // $post = Employee::find($id);
        // $post->users()->attach(Auth::id());
        $post->user_id = Auth::id();
        return new LikeForShowResource($like);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Like $like)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //$post = Post::find($id);
        //$post->users()->attach(Auth::id());
        // $post = Employee::find($id);
        // $post->users()->attach(Auth::id());
        $like = Like::where('tweet_id', $id)->where('tweet_id', Auth::id())->first();
        $like->delete();
        return response()->json([
            'result' => true,
        ]);
    }
    public function userid(){
        return Auth::id();
    }
    public function username(){
        return Auth::user()->name;
    }
}
