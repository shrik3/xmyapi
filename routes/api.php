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
        $api->resource('community', 'CommunityController', ['only' => ['index', 'show']]);
        $api->resource('article', 'ArticleController', ['only' => ['index', 'show']]);

        $api->get('/article/{id}/comments', 'CommentController@show');

        // 用户相关
        $api->post('/user/register', 'UserController@register');
        $api->post('/user/auth', 'UserController@auth');
        $api->get('/membership', 'Admin\MembershipController@index');



        // 需要鉴权
        $api->group(['middleware' => 'api.auth', 'namespace' => 'User'], function ($api){
           $api->get('/user/getinfo',"InfoController@getinfo"); 
           $api->post('/user/change_nickname',"InfoController@change_nickname"); 

        });

        $api->group(['middleware' => 'api.auth', 'namespace' => 'Admin'], function ($api) {
            // testing

            // get user info :
            
            $api->post('/secrets/{id}', 'TestController@test');
            $api->get('/my','MembershipController@my_groups');

            $api->resource('/manage/community', 'CommunityController');
            $api->resource('/manage/article', 'ArticleController');
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
