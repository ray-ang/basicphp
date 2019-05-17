<?php

/**
 * BasicPHP - A PHP Nano-Framework for Decoupled Application Logic and Presentation
 *          - The aim of the project is for developers to build applications that
 *          - are framework-independent by decoupling the Controller and View from
 *          - any framework, making the application portable and compatible with the
 *          - developer's framework of choice or vanilla PHP.
 *          -
 *          - BasicPHP's core file (core.php), particularly the Core Functions, can be
 *          - embedded in the chosen framework's front controller, and the (1) classes,
 *          - (2) controllers and (3) views folders copied one folder above the
 *          - front controller of the chosen framework.
 *
 * @package  BasicPHP
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

// Register the start time as a float value
$time_start = floatval(microtime());

// Start sessions
session_start();

/*
|--------------------------------------------------------------------------
| Register The Class Autoloader
|--------------------------------------------------------------------------
|
| Folders containing classes that need to be autoloaded should be added to
| the array variable $class_folders.
|
*/

spl_autoload_register(function ($class_name) {

	// Add class folders to autoload
	$class_folders[] = 'classes';
	$class_folders[] = 'controllers';

	foreach ($class_folders as $folder) {

		if (file_exists('../' . $folder . '/' . $class_name . '.php') && is_readable('../' . $folder . '/' . $class_name . '.php')) {

			require_once '../' . $folder . '/' . $class_name . '.php';

		}

	}

});

/*
|--------------------------------------------------------------------------
| Set The Environment
|--------------------------------------------------------------------------
|
| Set the working environment. When working in a development environment,
| define 'ENV' as 'development'. When working in a production environment,
| define 'ENV' as 'production'. Error reporting is turned ON in development,
| and OFF in production environment.
|
*/

define('ENV', 'development');

switch (ENV) {
    case 'development':
        error_reporting(E_ALL);
        break;
    case 'production':
        error_reporting(0);
        break;
}

/*
|--------------------------------------------------------------------------
| Set URL and Folder Paths
|--------------------------------------------------------------------------
|
| Define 'BASE_URL' as the domain with '/' at the end, such as
| 'http://example.com/' or 'https://example.com/'.
| 
| If 'public/' folder is set as the DocumentRoot of the host or virtual host,
| set 'SUB_PATH' to ''.
| 
| If 'basicphp/' folder is located under the DocumentRoot folder, define
| 'SUB_PATH' as 'basicphp/public/' using the format 'sub-url/sub-url/'. This
| is the case when accessing the site at 'http://localhost/basicphp/public/'.
| 
| SUB_ORDER is the number of URL substrings from domain to /public/ path.
| If 'public/' folder is set as the DocumentRoot, SUB_ORDER is automatically
| set to 0. If 'basicphp/' folder is located under server DocumentRoot,
| SUB_ORDER is automatically set to 2.
|
*/

define('BASE_URL', 'http://localhost/');
define('SUB_PATH', 'basicphp/public/');
define('SUB_ORDER', substr_count(SUB_PATH, '/'));

/*
|--------------------------------------------------------------------------
| BasicPHP Core Functions
|--------------------------------------------------------------------------
| 
| These are core functions necessary to run the micro-framework:
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
 * Get URL substring value after /public/ path separated by '/'
 * SUB_ORDER should be set to 0 if 'public/' folder is server DocumentRoot
 * SUB_ORDER should be set to 2 if 'public/' folder is two folders below
 * the server DocumentRoot folder - such as when accessing the application at
 * 'http://localhost/basicphp/public/'.
 *
 * @param integer $position - Substring position from /public/ path
 */

function url_value($position)
{

    $url = explode('/', $_SERVER['REQUEST_URI']);
    $order = $position + SUB_ORDER;

    if (isset($url[$order])) $string = $url[$order];
    if (isset($string)) return $string;

}

/**
 * Load Class-based Controller based on substrings
 *
 * @param string $http_method - HTTP method (e.g. GET, POST, PUT, DELETE)
 * @param string $sub1 - First substring after /public/ path
 * @param string $sub2 - Second substring after /public/ path
 * @param string $class_method - ClassController@method format
 */

function route_class($http_method, $sub1, $sub2, $class_method)
{

	$class_method = explode('@', $class_method);

	$class = $class_method[0];
	$method = $class_method[1];

	if ( $_SERVER['REQUEST_METHOD'] == $http_method ) {

		$url_1 = url_value(1);
		$url_2 = url_value(2);
		$url_3 = url_value(3);

		if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

			$class_object = new $class();
			$class_object->$method();

		} elseif ( ! empty($url_1) && $sub1==$url_1 && empty($url_2) && $sub2==null && ! isset($url_3) ) {

			$class_object = new $class();
			$class_object->$method();

		}

	}

}

/**
 * Load File-based Controller based on substrings
 *
 * @param string $sub1 - First substring after /public/ path
 * @param string $sub2 - Second substring after /public/ path
 * @param string $controller - Controller file
 * Exlude .php extension from $controller argument.
 */

function route_file($http_method, $sub1, $sub2, $controller)
{

	if ( $_SERVER['REQUEST_METHOD'] == $http_method ) {

		$url_1 = url_value(1);
		$url_2 = url_value(2);
		$url_3 = url_value(3);

		if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

			require '../controllers/files/' . $controller . '.php';

		} elseif ( ! empty($url_1) && $sub1==$url_1 && empty($url_2) && $sub2==null && ! isset($url_3) ) {

			require '../controllers/files/' . $controller . '.php';

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

	// Show Header and Menu
	require '../views/template/header.php';
	require '../views/template/menu.php';

	// Render Page View
	require '../views/' . $view . '.php';

	// Show Footer
	require '../views/template/footer.php';

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

	$_SESSION['csrf-token'] = base64_encode(openssl_random_pseudo_bytes(32));
	return $_SESSION['csrf-token'];

}

// BasicPHP routing configurations
require_once 'routes.php';

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
|
| Invalid URI's include only two (2) files: the front controller (index.php)
| and the BasicPHP core file (core.php).
| Any valid page rendered, even the error page, will need to require a file
| other than the front controller and core files. The script below should be
| run last to avoid conflict with routing configuration.
|
*/

if (count(get_included_files())==2) {

	$error_message = '<h3 style="text-align: center;">Error 404. Page not found. This is an Invalid URL.</h3>';
	$page_title = 'Error 404';

	$data = compact('error_message', 'page_title');

	view('error', $data);

}

// // Register the end time as a float value
// $time_end = floatval(microtime());

// // Compute the elapsed time
// $time_lapse = $time_end - $time_start;

// echo 'Start: ' . $time_start . '<br/>';
// echo 'End: ' . $time_end . '<br/>';
// echo 'Lapse Time: ' . $time_lapse . '<br/>';

// // Compute average load speed. Set $_SESSION['speed'] as an array.
// if (! isset($_SESSION['speed'])) $_SESSION['speed'] = [];
// $_SESSION['speed'][] = $time_lapse;

// // Average load speed
// echo 'The average load speed is: ' . (array_sum($_SESSION['speed'])/count($_SESSION['speed']));

// var_dump($_SESSION['speed']);

// // Place a comment on session_destroy() to start computing average load speed.
// session_destroy();