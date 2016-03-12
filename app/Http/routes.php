<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Carbon\Carbon;

Route::get('/', function () {
//    return view('welcome');
    return Carbon::now();
});
Route::get('/home', function () {
    return view('welcome');
//    return Carbon::now();
});

Route::resource('article', 'ArticleController');

Route::resource('user', 'UserController');

Route::resource('friendship', 'FriendshipController');

Route::get('user/{user}/article', 'UserController@articleList');

Route::controllers([
    'auth' => 'Auth\AuthController',
]);


//// 认证路由...
//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
//// 注册路由...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

//Route::Get('/article', 'ArticleController@index');
//Route::Get('article/create', 'ArticleController@create');
//Route::POST('article',  'ArticleController@store');
//Route::GET('article/{article}', 'ArticleController@show');
//Route::GET('article/{article}/edit', 'ArticleController@edit');
//Route::PUT('article/{article}', 'ArticleController@update');
//Route::DELETE('article/{article}', 'ArticleController@destroy');

