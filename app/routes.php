<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	//return Config::get('app.name');
	return View::make('home');
});

Route::get('/browse', 'BookController@showAll');

Route::get('/book/{id?}', 'BookController@showSingle');

Route::post('login', 'UserController@login');

Route::get('logout', 'UserController@logout');

Route::post('request', 'BookController@request');