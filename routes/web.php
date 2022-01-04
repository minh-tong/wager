<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'json_request'], function () use ($router) {
    $router->post('/wagers',  ['uses' => 'WagerController@index', 'as' => 'create_wager']);
    $router->get('/wagers',  ['uses' => 'WagerListController@index', 'as' => 'get_wagers']);
    $router->post('/buy/{id}',  ['uses' => 'BuyController@index', 'as' => 'buy_wager']);
});