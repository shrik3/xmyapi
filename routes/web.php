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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/room','Web\AppointmentController@show');

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::auth();
Route::group(['middleware' => 'auth', 'namespace' => 'Web\Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@index');
    Route::resource('article','ArticleController');
    // Route::resource('photo','PhotoController');
    Route::resource('community','CommunityController');
    Route::get('/test','TestController@test');
    Route::get('modifyuser','SuperUserController@modify_user');
    Route::post('changeicon','SuperUserController@change_icon');
    }
);
