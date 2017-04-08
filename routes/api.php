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
    $api->get('test','\App\Http\Controllers\Api\V1\UserController@test');
    $api->resource('community','\App\Http\Controllers\Api\V1\CommunityController');
    $api->resource('article','\App\Http\Controllers\Api\V1\ArticleController');

    $api->post('/users/register','UserController@register');



});



/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
