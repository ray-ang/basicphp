<?php

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
| Activate automatic routing of url_value(1) and (2) as Class and Method
|--------------------------------------------------------------------------
*/

route_auto();

/*
|--------------------------------------------------------------------------
| Manual Routing Using Controllers
|--------------------------------------------------------------------------
*/

route_class('POST', '/api/response', 'ApiController@index');

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

}