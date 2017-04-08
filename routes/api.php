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
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
        $api->get('/hello/', 'UserController@index');
        $api->get('test/{id}','TestController@show');
        $api->resource('community','CommunityController');
        $api->resource('article','ArticleController');

        // 用户相关
        $api->post('/user/register','UserController@register');


    });


  });




/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
