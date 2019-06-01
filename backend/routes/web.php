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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('/', 'UserController@index');
            $router->get('{id:\d*}', 'UserController@getUser');
            $router->post('find', 'UserController@findUser');
            $router->post('create', 'UserController@createUser');
            $router->post('{id:\d*}/update', 'UserController@updateUser');
        });
        $router->group(['prefix' => 'type'], function () use ($router) {
            $router->get('/', 'TypeController@index');
            $router->get('{id:\d*}', 'TypeController@getType');
            $router->post('create', 'TypeController@createType');
            $router->post('{id:\d*}/update', 'TypeController@updateType');
        });
    });
});
