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

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group([
        'prefix' => 'user', 
        'middleware'=> 'auth'
    ], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->get('info', 'UserController@info');
        $router->get('search', 'UserController@search');
        $router->get('child/{user_id:\d*}', 'UserController@child');
        $router->post('create', 'UserController@create');
        $router->post('child/create', 'UserController@childCreate');
        
        $router->group(['prefix' => 'permission'], function () use ($router) {
            $router->post('create', 'UserController@permissionCreate');
            $router->get('detail/{user_id:\d*}', 'UserController@permissionDetail');
        });
    });

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('login', 'AuthController@login');
    });

    $router->group([
        'prefix' => 'permission',
        'middleware'=> 'auth'
    ], function () use ($router) {
        $router->get('/', 'PermissionController@index');
        $router->get('getByProject/{project_id:\d*}', 'PermissionController@getByProject');
        $router->get('{id:\d*}', 'PermissionController@getById');
        $router->post('create', 'PermissionController@create');
        $router->put('update/{id:\d*}', 'PermissionController@update');
        $router->group(['prefix' => 'module'], function () use ($router) {
            $router->get('/{project_id:\d*}', 'PermissionController@listModule');
            $router->post('create', 'PermissionController@createModule');
        });
        $router->group(['prefix' => 'project'], function () use ($router) {
            $router->get('/', 'PermissionController@listProject');
            $router->post('create', 'PermissionController@createProject');
        });
        $router->group(['prefix' => 'position'], function () use ($router) {
            $router->get('/', 'PermissionController@position');
            $router->get('search', 'PermissionController@positionSearch');
            $router->post('create', 'PermissionController@positionCreate');
        });
    });
});