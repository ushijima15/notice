<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TestForList as TestForListResource;
use App\Http\Resources\TestForShow as TestForShowResource;
use App\Http\Resources\TestForSelector as TestForSelectorResource;
use App\Test;
use App\User;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();
        return TestForListResource::collection($tests);
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
            $test = new Test;
            $test->text = $request->test['text'];
            $test->id = $request->test['id'];
            $test->tweet_id = $request->test['tweet_id'];
            $test->save();
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
    public function show(Test $test)
    {
        return new TestForShowResource($test);
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
        $count = Test::where([
            ['id', '<>', $test->id],
            ['code', $request->test['code']]
        ])->count();
        DB::transaction(function () use ($request, $test) {
            $test->text = $request->test['text'];
            $test->id = $request->test['id'];
            $test->tweet_id = $request->test['tweet_id'];
            $test->save();
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
    public function destroy($id)
    {
        DB::transaction(function () use ($test) {
            $test->delete();
        });

        return response()->json([
            'result' => true,
        ]);
    }
}
