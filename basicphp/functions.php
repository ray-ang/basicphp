<?php

/*
|--------------------------------------------------------------------------
| BasicPHP Functions Library
|--------------------------------------------------------------------------
| 
| These are core functions necessary to run the nano-framework:
|
| 1. url_value() - retrieves the URL substring separated by '/'
| 2. route_class() - routes URL request to Class-based Controllers
| 3. route_file() - routes URL request to File-based Controllers
| 4. view() - passes data and renders the View
| 5. pdo_conn() - PHP Data Objects (PDO) database connection
| 6. api_response() - handles API response
| 7. api_call() - handles API call
| 8. esc() - uses htmlspecialchars() to prevent XSS
| 9. csrf_token() - uses sessions to create per request CSRF token
|
*/

/**
 * Get URL path string value after the BASE_URL.
 *
 * @param integer $order - Substring position from the BASE_URL
 */

function url_value($order)
{

    if (isset($_GET['url-path'])) { $url = explode('/', $_GET['url-path']); }

    if (isset($url[$order])) { return $url[$order]; }

}

/**
 * Load Class-based Controller based on substrings
 * Can be used in creating pages and route views
 *
 * @param string $http_method - HTTP method (e.g. GET, POST, PUT, DELETE)
 * @param string $sub1 - First substring after the BASE_URL
 * @param string $sub2 - Second substring after the BASE_URL
 * @param string $class_method - ClassController@method format
 */

function route_class($http_method, $sub1, $sub2, $class_method)
{

	$class_method = explode('@', $class_method);
	$class = $class_method[0];
	$method = $class_method[1];

	if ( $_SERVER['REQUEST_METHOD'] == $http_method ) {

		$url_1 = url_value(0);
		$url_2 = url_value(1);
		$url_3 = url_value(2);

		if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

			$class_object = new $class();
			return $class_object->$method();

		} elseif ( ! empty($url_1) && $sub1==$url_1 && empty($url_2) && $sub2==null && ! isset($url_3) ) {

			$class_object = new $class();
			return $class_object->$method();

		}

	}

}

/**
 * Load File-based Controller based on substrings
 * Can be used in developing API's
 *
 * @param string $http_method - HTTP method (e.g. GET, POST, PUT, DELETE)
 * @param string $sub1 - First substring after the BASE_URL
 * @param string $sub2 - Second substring after the BASE_URL
 * @param string $controller - Controller file (exclude .php extension).
 */

function route_file($http_method, $sub1, $sub2, $controller)
{

	if ( $_SERVER['REQUEST_METHOD'] == $http_method ) {

		$url_1 = url_value(0);
		$url_2 = url_value(1);
		$url_3 = url_value(2);

		if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

			require_once '../controllers/files/' . $controller . '.php';

		} elseif ( ! empty($url_1) && $sub1==$url_1 && empty($url_2) && $sub2==null && ! isset($url_3) ) {

			require_once '../controllers/files/' . $controller . '.php';

		}

	}

}

/**
 * Passes data and renders the View
 *
 * @param string $view - View file, excluding .php extension
 * @param array $data - Data as an array to pass to the View
 */

function view($view, $data=null)
{

	// Convert array keys to variables
	if ( isset($data) ) { extract($data); }

	// Render Page View
	require_once '../views/' . $view . '.php';

}

/**
 * PHP Data Objects (PDO) database connection
 *
 * @param string $database - Database (e.g. mysql)
 * @param string $servername - Server Name (e.g localhost)
 * @param string $dbname - Database Name
 * @param string $username - Username
 * @param string $password - Password
 */

function pdo_conn($database, $servername, $dbname, $username, $password)
{

	$conn = new PDO("$database:host=$servername;dbname=$dbname", $username, $password, array(
		PDO::ATTR_PERSISTENT => true
	));
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;

}

/**
 * Handles the HTTP REST API Response
 *
 * @param array $data - Array to be encoded to JSON
 * @param string $message - Message to send with response
 */

function api_response($data, $message=null)
{

	// Define content type as JSON data through the header
	header("Content-Type: application/json; charset=utf-8");

	// Data and message as arrays to send with response
	$response['data'] = $data;
	$response['message'] = $message;

	// Encode $response array to JSON
	echo json_encode($response);

}

/**
 * Handles the HTTP REST API Calls
 *
 * @param string $http_method - HTTP request method (e.g. 'GET', 'POST')
 * @param string $url - URL of external server API
 * @param string $data - POST fields in array
 * @param string $username - Username
 * @param string $password - Password
 */

function api_call($http_method, $url, $data=null, $username=null, $password=null)
{

	// Initialize cURL
	$ch = curl_init();

	// Convert $data array parameter to JSON
	$data_json = json_encode($data);

	// Set cURL options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
	// curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',                                                                                
	    'Content-Length: ' . strlen($data_json))                                                                       
	);

	// Execute cURL
	$result = curl_exec($ch);

	// Close cURL connection
	curl_close ($ch);

	// Convert JSON response from external server to an array
	$data_output = json_decode($result, true);

	return $data_output;

}

/**
 * Helper function to prevent Cross-Site Scripting (XSS)
 * Uses htmlspecialchars() to prevent XSS
 *
 * @param string $string - String to escape
 */

function esc($string)
{

	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

}

/**
 * Helper function to prevent Cross-Site Request Forgery (CSRF)
 * Creates a per request token to handle CSRF using sessions
 */

function csrf_token()
{

	if ( isset($_SESSION) ) {

		$_SESSION['csrf-token'] = bin2hex(random_bytes(32));
		return $_SESSION['csrf-token'];

	} else {

		$error_message = 'Please initialize Sessions.';
		$page_title = 'Sessions Error';

		$data = compact('error_message', 'page_title');
		view('error', $data);

	}

}