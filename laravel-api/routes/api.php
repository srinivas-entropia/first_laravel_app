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
\Log::debug("cors chewcking in route doesnt exist");
Route::group(['middleware' => ['api', 'cors'],'namespace' => 'Auth'],function(){
    \Log::debug("cors chewcking in route exist");
    Route::post('signup', 'RegisterController@create');
    Route::post('login', 'RegisterController@login');
    Route::get('dashboard-data', 'RegisterController@DashboardData');
    Route::post('logout', 'RegisterController@logout');
});