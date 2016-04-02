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
    \App\User::create(
        ['name' => 'Ryan Chenkie',
            'email' => 'ryanchenkie@gmail.com',
            'password' => Hash::make('secret')]);

    return view('welcome');
});


Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('register', 'AuthenticateController@register');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

    Route::resource('users', 'UsersController');
    Route::resource('projects', 'ProjectsController');
    Route::resource('projects.folders', 'ProjectFoldersController');
    Route::resource('progress', 'ProgressController');
});
