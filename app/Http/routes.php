<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/login', ['uses'=>'Auth\AuthController@login']);
$app->post('/login', ['uses'=>'Auth\AuthController@authenticate']);
$app->get('/signup', ['uses'=>'Auth\AuthController@signup']);
$app->post('/signup', ['uses'=>'Auth\AuthController@register']);
$app->get('/logout', ['uses'=>'Auth\AuthController@logout']);

$app->group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function ($app) {
    $app->get('/', ['uses'=>'AppController@main']);
    
    $app->post('/workday', ['uses'=>'WorkdayController@store', 'as' => 'workday.store']);
    
    $app->put('/workday/{id}', ['uses'=>'WorkdayController@update', 'as' => 'workday.update']);
    
    $app->delete('/workday/{id}', ['uses'=>'WorkdayController@destroy', 'as' => 'workday.destroy']);
});