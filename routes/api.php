<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace'=>'Api','prefix'=>'api','middleware'=>'api'],function (){
    //不需要token接口

    //api 需要token接口
    Route::group(['middleware'=>'apiAuth'],function (){
        //不需要token接口

        //api 需要token接口

    });
});
