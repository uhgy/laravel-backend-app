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

Route::get('/', function () {
    $test = 'test';
    return view('welcome');
});


Route::resource('article', 'ArticleController');

//Route::Get('/article', 'ArticleController@index');
//Route::Get('article/create', 'ArticleController@create');
//Route::POST('article',  'ArticleController@store');
//Route::GET('article/{article}', 'ArticleController@show');
//Route::GET('article/{article}/edit', 'ArticleController@edit');
//Route::PUT('article/{article}', 'ArticleController@update');
//Route::DELETE('article/{article}', 'ArticleController@destroy');

