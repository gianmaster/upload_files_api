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
    return view('welcome');
});

Route::get('/test', function(){
    return \Webpatser\Uuid\Uuid::generate(4);
});

Route::get('/usuarios', function(){
    return App\User::all();
});

/**
 * Rutas del API - Dingo Implementation
 */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api){

    //$api->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'testing'],
    $api->group(['namespace' => 'App\Http\Controllers'],function($api){

        $api->resource('users', 'UsersController');

    });

});
