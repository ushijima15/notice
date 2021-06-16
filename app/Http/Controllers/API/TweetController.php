<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TweetForList as TweetForListResource;
use App\Http\Resources\TweetForShow as TweetForShowResource;
use App\Http\Resources\TweetForSelector as TweetForSelectorResource;
use App\Tweet;
use App\User;
use App\Like;
class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::all();
        return TweetForListResource::collection($tweets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $tweet = new Tweet;
            $tweet->text = $request->tweet['text'];
            $tweet->id = $request->tweet['id'];
            $tweet->save();
        });

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
    public function show(Tweet $tweet)
    {
        return new TweetForShowResource($tweet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $tweet) {
            $tweet->text = $request->tweet['text'];
            $tweet->id = $request->tweet['id'];
            $tweet->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        DB::transaction(function () use ($tweet) {
            $tweet->delete();
        });

        return response()->json([
            'result' => true,
        ]);
    }
    public function addgood(Request $request,$id)
    {
        Like::create([
            'tweet_id' => $id,
            'user_id' => Auth::id(),
        ]);
        // DB::transaction(function () use ($request) {
        //     $like = new Like;
        //     $like->tweet_id = $request->tweet['id'];
        //     $like->user_id = $request->Auth::id();
        //     $like->save();
        // });
        //session()->flash('success', 'You Liked the Reply.');
        //return redirect()->back();
        return response()->json([
            'result' => true,
        ]);
    }
    public function deletegood(Request $request,$id)
    {
       $like = Like::where('tweet_id', $id)->where('user_id', Auth::id())->first();
       $like->delete();
   
       //session()->flash('success', 'You Unliked the Reply.');
   
       //return redirect()->back();
        return response()->json([
            'result' => true,
        ]);
    }
}
