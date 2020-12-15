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
    //退出登录
    Router::addRoute(['GET', 'POST'], 'auth/logout', 'App\Controller\AuthController@logout');

    //楼栋
    Router::addGroup('build/', function () {
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\BuildController@list');
        Router::addRoute(['GET', 'POST'], 'create', 'App\Controller\BuildController@create');
        Router::addRoute(['GET', 'POST'], 'edit', 'App\Controller\BuildController@edit');
        Router::addRoute(['GET', 'POST'], 'delete', 'App\Controller\BuildController@delete');
        Router::addRoute(['GET', 'POST'], 'tree', 'App\Controller\BuildController@tree');
    });

    //房间
    Router::addGroup('room/', function () {
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\AreaController@list');
        Router::addRoute(['GET', 'POST'], 'create', 'App\Controller\AreaController@create');
        Router::addRoute(['GET', 'POST'], 'edit', 'App\Controller\AreaController@edit');
        Router::addRoute(['GET', 'POST'], 'delete', 'App\Controller\AreaController@delete');
        Router::addRoute(['GET', 'POST'], 'param-list', 'App\Controller\AreaController@areaParamList');
    });

    //租户
    Router::addGroup('tenant/', function () {
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\TenantController@list');
        Router::addRoute(['GET', 'POST'], 'edit', 'App\Controller\TenantController@edit');
    });

    //租约
    Router::addGroup('lease/', function () {
        Router::addRoute(['GET', 'POST'], 'list', 'App\Controller\LeaseController@list');
        Router::addRoute(['GET', 'POST'], 'create', 'App\Controller\LeaseController@create');
        Router::addRoute(['GET', 'POST'], 'edit', 'App\Controller\LeaseController@edit');
        Router::addRoute(['GET', 'POST'], 'delete', 'App\Controller\LeaseController@delete');
    });

}, ['middleware' => [AuthMiddleware::class]]);