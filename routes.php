<?php

/*
|--------------------------------------------------------------------------
| JSON-RPC v2.0 Compatibility Layer with 'method' member as 'class.method'
|--------------------------------------------------------------------------
*/

// Check if HTTP request method is 'POST', if there is POSTed data, and the POSTed data is in JSON format.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && file_get_contents('php://input') !== false && json_decode( file_get_contents('php://input'), true ) !== null) {

	$json_rpc = json_decode( file_get_contents('php://input'), true );

	// Requires the 'jsonrpc', 'method' and 'id' members of the request object
	if (isset($json_rpc['jsonrpc']) && isset($json_rpc['method']) && isset($json_rpc['id'])) {

		if (strstr($json_rpc['method'], '.') == false) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => 32600, 'message' => "The JSON-RPC 'method' member should have the format 'class.method'."], 'id' => $json_rpc['id']]));

		list($class, $method) = explode('.', $json_rpc['method']);
		$class = ucfirst($class) . CONTROLLER_SUFFIX;
		$method = lcfirst($method);

		if (class_exists($class)) {
			$object = new $class();
			if ( method_exists($object, $method) ) {
				return $object->$method();
				exit();
			} else { exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => 32601, 'message' => "Method not found."], 'id' => $json_rpc['id']])); }
		} else { exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => 32601, 'message' => "Class not found."], 'id' => $json_rpc['id']])); }
	}

}

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
| Render Homepage with JSON-RPC v2.0 Compatibility Layer
|--------------------------------------------------------------------------
*/

if ( ! isset($_SERVER['PATH_INFO']) && ! isset($json_rpc['method']) ) {

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

route_class('GET', '/response/from/(:any)/(:num)', 'ApiController@index');

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