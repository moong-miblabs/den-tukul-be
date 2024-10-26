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
    return env('APP_NAME',$router->app->version());
});

$controller = 'Provinsi';
$router->group(['prefix' => 'provinsi'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'KabKota';
$router->group(['prefix' => 'kab-kota'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Kecamatan';
$router->group(['prefix' => 'kecamatan'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Kelurahan';
$router->group(['prefix' => 'kelurahan'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Jenjang';
$router->group(['prefix' => 'jenjang'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Agama';
$router->group(['prefix' => 'agama'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Pekerjaan';
$router->group(['prefix' => 'pekerjaan'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Penghasilan';
$router->group(['prefix' => 'penghasilan'], function () use ($router,$controller) {
    $router->get('/', ['uses' => $controller.'@get']);
    $router->get('/{id}', ['uses' => $controller.'@get']);
});

$controller = 'Login';
$router->group(['prefix' => 'login'], function () use ($router,$controller) {
    $router->post('register', ['uses' => $controller.'@register']);
    $router->post('login', ['uses' => $controller.'@login']);
});