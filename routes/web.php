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


Auth::routes();

//Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');

// Route::get('/', 'HomeController@index')->middleware('verified')->name('home');

Route::group(['prefix' => 'oauth'], function () {
    Route::get('/authorize', 'TokenController@requestCode');

    Route::get('/authorize/callback', 'TokenController@exchangeCodeForToken');
});

Route::pattern('user', '^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}){1}$');
Route::group(['prefix' => 'users', 'as' => 'users.',], function () {
    Route::get('/{user}/profile', 'UserController@showProfile')->name('profile');
    Route::put('/{user}/profile', 'UserController@updateProfile')->name('profile.update');
});
