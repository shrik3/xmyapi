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

        $api->get('/article/{id}/comments','CommentController@show');

        // 用户相关
        $api->post('/user/register','UserController@register');
        $api->post('/user/auth','UserController@auth');

        // 需要鉴权
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->post('/secrets/',function(){return ('this is under auth protection');});
        });


    });


  });




/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
