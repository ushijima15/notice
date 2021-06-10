<?php

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy machine your API!
|
*/

Route::middleware('auth:api')->get('/user/info', function (Request $request) {
    return new UserResource($request->user());
});
Route::middleware(['api'])->group(function () {
    // バーコードアプリからの受取用
    Route::post('recieve_UoAODaKi', 'API\BarcodeController@recieve');
});
// Route::middleware(['auth:myauth'])->group(function () {
//     // バーコードアプリからの受取用
//     Route::post('/barcode/recieve', 'API\BarcodeController@recieve');
// });

Route::middleware(['auth:api'])->group(function () {
    Route::get('productcost', 'API\ProductCostController@index');
    Route::post('productcost/create/{product_plan}', 'API\ProductCostController@create');
    Route::get('productcost/{productcost}', 'API\ProductCostController@resume');
    Route::put('productcost/{productcost}', 'API\ProductCostController@update');
    Route::delete('productcost/{productcost}', 'API\ProductCostController@destroy');
    Route::get('productcost/download', 'API\ProductCostController@download');
    Route::get('productcost/itemSelector', 'API\ProductCostController@itemSelector');
    Route::get('productcost/selector', 'API\ProductCostController@selectorForSearch');
    
    // 作業日報（作業）
    Route::post('productcost/start_product_time/{product_cost}', 'API\ProductCostController@startProductTime');
    Route::post('productcost/stop/{product_cost}', 'API\ProductCostController@stop');
    Route::post('productcost/all_finish/{product_cost}', 'API\ProductCostController@allFinish');
    
    // csvダウンロード
    Route::post('productcost/download', 'API\ProductCostController@download');
    Route::get('productcost/csv_time', 'API\ProductCostController@finishCSVtime');
    
    // 従業員
    Route::get('employee', 'API\EmployeeController@index');
    Route::post('employee', 'API\EmployeeController@store');
    Route::get('employee/{employee}', 'API\EmployeeController@show');
    Route::put('employee/{employee}', 'API\EmployeeController@update');
    Route::delete('employee/{employee}', 'API\EmployeeController@destroy');
    Route::get('employee/selector', 'API\EmployeeController@selector');
    Route::get('employee/full_name', 'API\EmployeeController@fullname');

    // csv取込
    //Likes
    Route::get('/like', 'LikeController@index');//ブラウザでアクセスする。
    Route::get('/ajax/like/user_list', 'LikeController@user_list');//ユーザー情報を取得
    Route::post('/ajax/like', 'LikeController@like');//いいねデータを追加
    //Testのルーティング設定
    Route::get('test', 'API\TestController@index');
    Route::post('test', 'API\TestController@store');
    Route::get('test/{test}', 'API\TestController@show');
    Route::put('test/{test}', 'API\TestController@update');
    //Tweetのルーティング設定
    Route::get('tweet', 'API\TweetController@index');
    Route::post('tweet', 'API\TweetController@store');
    Route::get('tweet/{tweet}', 'API\TweetController@show');
    Route::put('tweet/{tweet}', 'API\TweetController@update');
});
