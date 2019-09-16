<?php

/*
|--------------------------------------------------------------------------
| Allow only alphanumeric and GET request characters on the Request URI
|--------------------------------------------------------------------------
*/

if (isset($_SERVER['REQUEST_URI']) && preg_match('/[^a-zA-Z0-9\_\/\?\&\=\-]/i', $_SERVER['REQUEST_URI']) ) {

    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
    exit('<h1>The URI should only contain alphanumeric and GET request characters.</h2>');

}

/*
|--------------------------------------------------------------------------
| Allow only whitelisted characters in $_POST global variable array.
|--------------------------------------------------------------------------
*/

if (isset($_POST) && preg_match('/[^a-zA-Z0-9\_\/\?\&\=\-\.]/i', implode('/', $_POST)) ) {

    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
	exit('<h1>Submitted data should only contain whitelisted characters.</h1>');
	
}

/*
|--------------------------------------------------------------------------
| JSON-RPC v2.0 Compatibility Layer with 'method' member as 'class.method'
|--------------------------------------------------------------------------
*/

route_rpc();

/*
|--------------------------------------------------------------------------
| Render Homepage with JSON-RPC v2.0 Compatibility Layer
|--------------------------------------------------------------------------
*/

if ( empty(url_value(1)) && ! isset($json_rpc['method']) ) {

	list($class, $method) = explode('@', HOME_PAGE);
	$object = new $class();
	return $object->$method();

}

/*
|--------------------------------------------------------------------------
| Automatic Routing of url_value(1) and (2) as '/class/method' path
|--------------------------------------------------------------------------
*/

route_auto();

/*
|--------------------------------------------------------------------------
| Manual Routing Using Endpoints and Wildcards to Controllers
|--------------------------------------------------------------------------
*/

route_class('GET', '/posts', 'AppController@listUsers');
route_class('GET' || 'POST', '/posts/(:num)', 'AppController@viewUser');
route_class('GET' || 'POST', '/posts/(:num)/edit', 'AppController@editUser');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
|
| Invalid page includes only four (4) files: the front controller (index.php),
| config.php, functions.php and routes.php.
|
*/

if ( count(get_included_files()) == 4 ) {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit();

}