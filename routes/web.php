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

Route::get('/', 'VideoController@index');

Route::get('/videos', 'VideoController@index');

Route::get('/videos/create', [
	'as' => 'video.create',
	'uses' =>'VideoController@create',
]);

Route::post('/videos/create', 'VideoController@store');

Route::get('/videos/{id}', [
    'as' => 'video',
    'uses' => 'VideoController@show',
]);