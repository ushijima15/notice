<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/employees/{employee?}/firstcheck', 'LikeController@firstcheck')->name('like.firstcheck');
Route::get('/employees/{employee?}/check', 'LikeController@check')->name('like.check');
Route::get('/{any}', function () {
    Route::auth();
    return view('layouts.app');
})->where('any', '.*')->middleware('auth');