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
    $router->get('/mass/label', 'MassController@label');    //添加标签
    $router->get('/mass/labeldo', 'MassController@label');    //添加标签

    $router->get('/mass/thelabel', 'MassController@thelabel');  //获取标签
    $router->get('/mass/make', 'MassController@make');  //批量为用户打标签展示
    $router->post('/mass/makeadd', 'MassController@makeadd');  //批量为用户打标签

    $router->get('/mass/thelabelmass', 'MassController@thelabelmass');  //获取用户身上的标签列表
    $router->post('/mass/thelabelmasso', 'MassController@thelabelmasso');  //标签发送

});
