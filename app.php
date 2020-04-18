<?php

/*
|--------------------------------------------------------------------------
| Load BasicPHP Functions Library and Configuration File
|--------------------------------------------------------------------------
*/

require_once 'functions.php';
require_once 'config.php';

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

firewall(); // Firewall
force_ssl(); // SSL/HTTPS

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/

route_auto(); // Automatic '/class/method' routing
homepage(); // Render homepage

/*
|--------------------------------------------------------------------------
| Endpoint Routing
|--------------------------------------------------------------------------
*/

route_class('POST', '/jsonrpc', 'JsonRpcController@index');
route_class('GET', '/posts', 'AppController@listUsers');
route_class('GET' || 'POST', '/posts/(:num)', 'AppController@viewUser');
route_class('GET' || 'POST', '/posts/(:num)/edit', 'AppController@editUser');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
*/

error404(); // Handle Error 404