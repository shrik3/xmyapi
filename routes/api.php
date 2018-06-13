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
           $api->get('/community/join/{id}',"CommunityController@join"); 
        });

        $api->group(['middleware' => 'api.auth', 'namespace' => 'Circle'], function ($api){
           $api->post('/circle/create',"CircleController@create"); 
           $api->post('/circle/icon/',"CircleController@icon"); 
           $api->get('/circle/join/{id}',"CircleController@join"); 
        });

        $api->group(['middleware' => 'api.auth', 'namespace' => 'Article'], function ($api){
            $api->post('/article/create',"ArticleController@create"); 
            $api->post('/article/comment',"ArticleController@comment"); 
            $api->get('/article/like/{id}',"ArticleController@like"); 
         });
 
        // some open api for article 
        $api->get('article/index', 'Article\ArticleController@index');
        $api->get('article/circle/{id}', 'Article\ArticleController@circle_index');
        $api->get('article/community/{id}', 'Article\ArticleController@community_index');
        $api->get('article/{id}/comments', 'Article\ArticleController@show_comments');
        $api->get('article/{id}', 'Article\ArticleController@show');


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
