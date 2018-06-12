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

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

        $api->get('/hello/', 'UserController@index');
        $api->get('test/', 'TestController@show');

        $api->post('filetest/', 'TestController@filetest');

        $api->resource('community', 'CommunityController', ['only' => ['index', 'show']]);
        $api->resource('circle', 'Circle\CircleController', ['only' => ['index', 'show']]);
        $api->resource('article', 'ArticleController', ['only' => ['index', 'show']]);

        $api->get('/article/{id}/comments', 'CommentController@show');

        // 用户相关
        $api->post('/user/register', 'UserController@register');
        $api->post('/user/auth', 'UserController@auth');
        $api->get('/membership', 'Admin\MembershipController@index');

        // test

        // 需要鉴权
        $api->group(['middleware' => 'api.auth', 'namespace' => 'User'], function ($api){
           $api->get('/user/getinfo',"InfoController@getinfo"); 
           $api->get('/user/mygroups',"InfoController@mygroups"); 
           $api->post('/user/change_nickname',"InfoController@change_nickname"); 
           $api->post('/user/change_icon',"InfoController@change_icon"); 

        });

        $api->group(['middleware' => 'api.auth', 'namespace' => 'Community'], function ($api){
           $api->post('/community/create',"CommunityController@create"); 
           $api->post('/community/icon/',"CommunityController@icon"); 
        });

        $api->group(['middleware' => 'api.auth', 'namespace' => 'Circle'], function ($api){
           $api->post('/circle/create',"CircleController@create"); 
           $api->post('/circle/icon/',"CircleController@icon"); 
        });




        $api->group(['middleware' => 'api.auth', 'namespace' => 'Admin'], function ($api) {
            // testing

            // get user info :
            
            $api->post('/secrets/{id}', 'TestController@test');
            $api->get('/my','MembershipController@my_groups');

            // membership controll
            $api->post('community/join', 'MembershipController@join');
        });


    });


});




/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
