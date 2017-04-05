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


$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function($api){
    $api->get('test/{id}','\App\Http\Controllers\TestController@show');
    $api->resource('community','\App\Http\Controllers\CommunityController');
    $api->resource('article','\App\Http\Controllers\ArticleController');

});



/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
