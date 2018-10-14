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


Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->middleware('verified')->name('home');

Route::get('/stellar', function(){
	return view('stellar');
});

Route::group(['prefix' => 'oauth'], function(){
    Route::get('/authorize', 'TokenController@requestCode');

    Route::get('/authorize/callback', 'TokenController@exchangeCodeForToken');
});
