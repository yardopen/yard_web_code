<?php

declare(strict_types=1);

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:47
 * Team Name HornIOT
 **/

use Hyperf\HttpServer\Router\Router;
use App\Middleware\AuthMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

//登录
Router::addRoute(['GET', 'POST'], '/auth/login', 'App\Controller\AuthController@login');

//权限访问
Router::addGroup('/', function () {

    //楼栋
    Router::addGroup('build/', function () {
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@list');
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@create');
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@edit');
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@delete');
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@tree');
    });

}, ['middleware' => [AuthMiddleware::class]]);