<?php

/**
 * BasicPHP - A PHP Micro-Framework for Decoupled Application Logic and Presentation
 *          - The aim of the project is for developers to build applications that
 *          - are framework-independent.
 *
 * @package  BasicPHP
 * @author   Raymund John Ang <raymund@open-nis.org>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Classes that need to be autoloaded should be placed in the 'classes' folder.
| Class-based Controllers are placed in 'controllers/classes/' folder
|
*/

$time_start = floatval(microtime());

session_start();

spl_autoload_register(function ($class_name) {

	$filename = '../classes/' . $class_name . '.php';

	if (file_exists($filename) && is_readable($filename)) {

		require_once '../classes/' . $class_name . '.php';

	}

});

spl_autoload_register(function ($class_name) {

	$filename = '../controllers/classes/' . $class_name . '.php';

	if (file_exists($filename) && is_readable($filename)) {

		require_once '../controllers/classes/' . $class_name . '.php';

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

if (ENV == 'development') {

	error_reporting(E_ALL);

} elseif (ENV == 'production') {

	error_reporting(0);

}

/*
|--------------------------------------------------------------------------
| Set URL and Folder Paths
|--------------------------------------------------------------------------
|
| Define 'BASE_URL' as the domain with '/' at the end, such as
| 'http://example.com/' or 'https://example.com/'.
| 
| If 'public' folder is set as the DocumentRoot of the host or virtual host,
| set 'SUB_PATH' to ''.
| 
| If 'basicphp' folder is located under the DocumentRoot folder, define
| 'SUB_PATH' as 'basicphp/public/' using the format 'sub-url/sub-url/'.
| 
| SUB_ORDER is the number of URL substrings from domain to /public/ path.
| If 'public' folder is set as the DocumentRoot, SUB_ORDER is automatically
| set to 0. If 'basicphp' folder is located under server DocumentRoot,
| SUB_ORDER is automatically set to 2.
|
*/

define('BASE_URL', 'http://localhost/');

define('SUB_PATH', 'basicphp/public/');

$sub_order = substr_count(SUB_PATH, '/');

define('SUB_ORDER', $sub_order);

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
|
*/

/**
 * Get URL substring after /public/ path separated by '/'
 * SUB_ORDER should be set to 0 if 'public' folder is server DocumentRoot
 * SUB_ORDER should be set to 2 if 'public' folder is two folders below DocumentRoot,
 * such as when accessing 'http://localhost/basicphp/public/'
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
 * @param string $class - Controller class
 * @param string $method - Controller instance method
 */

// Route to Class-based Controllers
function route_class($sub1, $sub2, $class, $method)

{

	$url_1 = url_value(1);
	$url_2 = url_value(2);

	if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

		$class_object = new $class();

		call_user_func(array($class_object, $method));

	} elseif ( ! empty($url_1) && $sub1==$url_1 && ! isset($url_2) && $sub2==null ) {

		$class_object = new $class();

		call_user_func(array($class_object, $method));

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

	if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

		require '../controllers/files/' . $controller . '.php';

	} elseif ( ! empty($url_1) && $sub1==$url_1 && ! isset($url_2) && $sub2==null ) {

		require '../controllers/files/' . $controller . '.php';

	}

}

/*
|--------------------------------------------------------------------------
| Set Routing Configuration
|--------------------------------------------------------------------------
| 
| If there are two substrings after the /public/ path separated by a '/',
| load the Controller file in the 'controllers' folder.
| 
| Functions url_value() and url_route() are used to retrieve the value of
| the URL substring, and to implement routing if there are two substrings
| after the /public/ path.
| 
| Note: If 'public' folder is the DocumentRoot, the two substrings will be
| in reference to the domain name, not the /public/ path.
|
*/

// Render Homepage
if ( $_SERVER['REQUEST_URI'] == '/' . SUB_PATH ) {

	$class_object = new Cont_Home();

	call_user_func(array($class_object, 'index'));

}

/**
 * Manual Routing Using Class-based Controllers
 * Set first substring after /public/ path as the first argument.
 * Set second substring after /public/ path as the second argument.
 * Set class as the third argument.
 * Set instance method as the fourth argument.
 */

route_class('home', null, 'Cont_Home', 'index');
route_class('welcome', null, 'Cont_Welcome', 'index');
route_class('error', null, 'Cont_Error', 'index');

/**
 * Browse 'http://localhost/basicphp/public/sample/route'
 * Based on the controller, only 2 parameters can be set after /route
 * Example: 'http://localhost/basicphp/public/sample/route/1/2'
 */

route_class('sample', 'route', 'Cont_Sample', 'route');

/**
 * Below are examples of file-based Controllers.
 * To ensure proper decoupling, but still adhere to conventional method of
 * assigning a Controller to a specific route, it is recommended to use
 * class-based Controllers instead.
 */

 // route_file('home', '', 'home');
 // route_file('welcome', '', 'welcome');
 // route_file('error', '', 'error');
 // route_file('sample', 'route', 'sample-route');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URL
|--------------------------------------------------------------------------
|
| Invalid URL's only include the front controller or index.php.
| Any valid page rendered, even the error page, will need to require a file
| other than the front controller file. The front controller should run this
| script last to avoid conflict with routing configuration.
|
*/

if (count(get_included_files())==1) {

	echo '<h3 style="text-align: center;">Error 404. Page not found. This is an Invalid URL.</h3>';

}

$time_end = floatval(microtime());

$time_lapse = $time_end - $time_start;

echo 'Start: ' . $time_start . '<br/>';

echo 'End: ' . $time_end . '<br/>';

echo 'Lapse Time: ' . $time_lapse . '<br/>';

if (! isset($_SESSION['speed'])) $_SESSION['speed'] = array();

array_push($_SESSION['speed'], $time_lapse);

var_dump($_SESSION['speed']);

echo 'The average load speed is: ' . (array_sum($_SESSION['speed'])/count($_SESSION['speed']));

session_destroy();