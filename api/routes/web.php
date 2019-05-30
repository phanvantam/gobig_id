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

$router->get('/', 'ExampleController@index');

$router->group(['prefix' => 'fanpage'], function () use ($router) {
    $router->get('/', 'FanpageController@index');

    $router->group(['prefix' => 'script'], function () use ($router) {
        $router->get('keyword/{fanpage_id:\d*}', 'FanpageController@scriptKeyword');
        $router->post('keyword/add/{fanpage_id:\d*}', 'FanpageController@scriptKeywordAdd');
        $router->get('keyword/beforeEdit/{id:\d*}', 'FanpageController@scriptKeywordBeforeEdit');
        $router->post('keyword/edit/{id:\d*}', 'FanpageController@scriptKeywordEdit');
        $router->get('search', 'FanpageController@searchScript');

        $router->get('started/beforeEdit/{fanpage_id:\d*}', 'FanpageController@scriptStartedBeforeEdit');
         $router->post('started/add/{fanpage_id:\d*}', 'FanpageController@scriptStartedAdd');
    });
   
    $router->get('scriptConnect/{fanpage_id:\d*}', 'FanpageController@listScriptConnect');
    $router->get('scriptPocess/{fanpage_script_id:\d*}', 'FanpageController@scriptProcess');

});

$router->group(['prefix' => 'script'], function () use ($router) {
    $router->get('/', 'ScriptController@index');
    $router->get('formData', 'ScriptController@formData');
    $router->post('add', 'ScriptController@add');
    $router->get('edit/{id:\d*}', 'ScriptController@beforeEdit');
    $router->post('edit/{id:\d*}', 'ScriptController@edit');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->get('/', 'CustomerController@index');
});

$router->group(['prefix' => 'formData'], function () use ($router) {
    $router->get('/', 'FormDataController@index');
    $router->post('add', 'FormDataController@add');
    $router->post('edit/{form_data_id:\d*}', 'FormDataController@edit');
    $router->get('show/{form_data_id:\d*}', 'FormDataController@show');
    $router->get('beforeEdit/{form_data_id:\d*}', 'FormDataController@beforeEdit');
    $router->post('addValue/{form_data_id:\d*}', 'FormDataController@addValue');
});

$router->group(['prefix' => 'webhook'], function () use ($router) {
    $router->get('/', 'WebhookController@index');
    $router->post('/', 'WebhookController@reply');
    $router->get('/log', 'WebhookController@log');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('add', 'UserController@add');
});
