<?php

/**
 * BasicPHP - A PHP Nano-Framework for Decoupled Application Logic and Presentation
 *          - The aim of the project is for developers to build applications that
 *          - are framework-independent by decoupling the Controller and View from
 *          - any framework, making the application portable and compatible with the
 *          - developer's framework of choice or vanilla PHP.
 *          -
 *          - BasicPHP's index.php code, with minor modifications, can be embedded
 *          - in the chosen framework's front controller, and the (1) classes,
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
| BasicPHP Helper Functions
|--------------------------------------------------------------------------
| 
| These are functions necessary to run the micro-framework:
|
| 1. url_value() - retrieve the URL substring
| 2. route_class() - route to Class-based Controllers
| 3. route_file() - route to File-based Controllers
| 4. esc() - uses htmlspecialchars() to prevent XSS
| 5. csrf_token() - uses sessions to create per request CSRF token
|
*/

/**
 * Get URL substring value after /public/ path separated by '/'
 * SUB_ORDER should be set to 0 if 'public/' folder is server DocumentRoot
 * SUB_ORDER should be set to 2 if 'public/' folder is two folders below
 * the server DocumentRoot folder - such as when accessing the application at
 * 'http://localhost/basicphp/public/'.
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
 * Load Class-based Controller if two substrings are set
 * @param string $sub1 - First substring after /public/ path
 * @param string $sub2 - Second substring after /public/ path
 * @param string $class - Controller class name
 * @param string $method - Controller instance method
 */

// Route to Class-based Controllers
function route_class($sub1, $sub2, $class, $method)

{

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

/**
 * Load File-based Controller if two substrings are set
 * @param string $sub1 - First substring after /public/ path
 * @param string $sub2 - Second substring after /public/ path
 * @param string $controller - Controller file
 * Exlude .php extension from $controller argument.
 */

// Route to File-based Controllers
function route_file($sub1, $sub2, $controller)

{

	$url_1 = url_value(1);
	$url_2 = url_value(2);
	$url_3 = url_value(3);

	if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

		require '../controllers/files/' . $controller . '.php';

	} elseif ( ! empty($url_1) && $sub1==$url_1 && empty($url_2) && $sub2==null && ! isset($url_3) ) {

		require '../controllers/files/' . $controller . '.php';

	}

}

/**
 * Helper function to prevent Cross-Site Scripting (XSS)
 * Uses htmlspecialchars() to prevent XSS
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

/*
|--------------------------------------------------------------------------
| Set Routing Configuration
|--------------------------------------------------------------------------
| 
| If there are two substrings after the /public/ path separated by a '/',
| load the class-based Controller in the 'controllers/classes/' folder.
| 
| Functions url_value() and route_class() are used to retrieve the value of
| the URL substring, and to implement routing if there are two substrings
| after the /public/ path.
| 
| Note: If 'public/' folder is the DocumentRoot, the two substrings will be
| in reference to the domain name, not the /public/ path.
|
*/

// Render Homepage
if ( $_SERVER['REQUEST_URI'] == '/' . SUB_PATH ) {

	$class_object = new Cont_Home();
	$class_object->index();

}

/**
 * Manual Routing Using Class-based Controllers
 * Set first substring after /public/ path as the first argument.
 * Set second substring after /public/ path as the second argument.
 * Set class name as the third argument.
 * Set instance method as the fourth argument.
 */

route_class('home', null, 'Cont_Home', 'index');
route_class('welcome', null, 'Cont_Welcome', 'index');
route_class('error', null, 'Cont_Error', 'index');

/**
 * Browse 'http://localhost/basicphp/public/sample/route'
 * Based on the controller, only 2 parameters can be set after /route/
 * Example: 'http://localhost/basicphp/public/sample/route/1/2'
 */

route_class('sample', 'route', 'Cont_Sample', 'route');
route_class('post', 'list', 'Cont_Post', 'list');
route_class('post', 'view', 'Cont_Post', 'view');
route_class('post', 'add', 'Cont_Post', 'add');
route_class('post', 'edit', 'Cont_Post', 'edit');


/**
 * Below are examples of File-based Controllers.
 * To ensure proper decoupling, but still adhere to conventional method of
 * assigning a Controller to a specific route, it is recommended to use
 * class-based Controllers instead.
 */

// route_file('home', null, 'home');
// route_file('welcome', null, 'welcome');
// route_file('error', null, 'error');
// route_file('sample', 'route', 'sample-route');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
|
| Invalid URI's only include the front controller or index.php.
| Any valid page rendered, even the error page, will need to require a file
| other than the front controller file. The front controller should run this
| script last to avoid conflict with routing configuration.
|
*/

use Basic_View as View;

if (count(get_included_files())==1) {

	$error_message = '<h3 style="text-align: center;">Error 404. Page not found. This is an Invalid URL.</h3>';

	$page_title = 'Error 404';

	$data = compact('error_message', 'page_title');

	View::page('error', $data);

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