<?php

/*
|--------------------------------------------------------------------------
| Load Configuration File and BasicPHP Class Library
|--------------------------------------------------------------------------
*/

require_once 'config.php';
require_once 'Basicphp.php';

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

Basicphp::firewall(); // Firewall
Basicphp::force_ssl(); // SSL/HTTPS

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/

Basicphp::route_auto(); // Automatic '/class/method' routing
Basicphp::homepage(); // Render homepage

/*
|--------------------------------------------------------------------------
| Endpoint Routing
|--------------------------------------------------------------------------
*/

Basicphp::route_class('POST', '/jsonrpc', 'JsonRpcController@index');
Basicphp::route_class('GET', '/posts', 'AppController@listUsers');
Basicphp::route_class('GET' || 'POST', '/posts/(:num)', 'AppController@viewUser');
Basicphp::route_class('GET' || 'POST', '/posts/(:num)/edit', 'AppController@editUser');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
*/

Basicphp::error404(); // Handle Error 404