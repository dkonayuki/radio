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
    return Redirect::route('home');
});
Route::get('/home', ['as' => 'home', function () {
    return Redirect::route('radios.index'); 
}]); 
Route::get('/profile', [
    'as' => 'profile', 'uses' => 'UsersController@profile'
]);
Route::get('/search', 'RadiosController@search');
Route::resource('radios', 'RadiosController');
Route::resource('users', 'UsersController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    ]);

Route::group(['prefix' => 'api/v1.0'], function()
{
    Route::get( 'radios/{radio}/programs/', 'APIRadiosController@programs');
    Route::get( 'radios/{radio}/programs/{program}', 'APIRadiosController@programs');
    #Route::resource('radios', 'APIRadiosController');
    Route::get('radios', ['middleware' => 'auth.basic', 'uses' => 'APIRadiosController@index']);
    Route::get('radios/{id}', ['middleware' => 'auth.basic', 'uses' => 'APIRadiosController@show']);
});

Route::get( 'batch/update', 'ApiBatchController@update');
Route::resource('batch', 'ApiBatchController');
