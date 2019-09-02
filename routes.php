<?php

/*
|--------------------------------------------------------------------------
| Allow only alphanumeric and GET request characters on the request URI
|--------------------------------------------------------------------------
*/

if (isset($_SERVER['REQUEST_URI']) && preg_match('/[^a-zA-Z0-9_\/?&=-]/i', $_SERVER['REQUEST_URI']) ) {

    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
    exit();

}

/*
|--------------------------------------------------------------------------
| Render Homepage
|--------------------------------------------------------------------------
*/

if ( ! isset($_SERVER['PATH_INFO']) ) {

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

// route_class('GET', '/response/from/(:any)/(:num)', 'ApiController@index');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
|
| Invalid page includes only four (4) files: the front controller (index.php),
| functions.php, config.php and routes.php.
|
*/

if ( count(get_included_files()) == 4 ) {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit();

}