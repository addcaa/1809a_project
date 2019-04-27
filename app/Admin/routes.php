<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/goods', GoodsController::class);
    $router->resource('/orderlist', OrderController::class);
    $router->resource('/userwx', UserController::class);
    $router->resource('/messag', MessagController::class);
    $router->get('/mass/list', 'MassController@list');
    $router->post('/mass/addo', 'MassController@addo');
    $router->get('/mass/label', 'MassController@label');
    $router->post('/mass/labelad', 'MassController@labelad');


});
