<?php

/**
 * BasicPHP - A PHP Micro-Framework for Decoupled Application and Presentation Logic
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
|
*/

spl_autoload_register(function ($class_name) {

	$filename = '../classes/' . $class_name . '.php';

	if (file_exists($filename) && is_readable($filename)) {

		require_once '../classes/' . $class_name . '.php';

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
 * Load Controller file if two substrings are set
 * @param string $sub1 - First substring after /public/ path
 * @param string $sub2 - Second substring after /public/ path
 * @param string $controller - Controller file
 * Exlude .php extension from $controller argument.
 */

function url_route($sub1, $sub2, $controller)

{

	$url_1 = url_value(1);
	$url_2 = url_value(2);

	if ( ! empty($url_1) && $sub1==$url_1 && ! empty($url_2) && $sub2==$url_2 )  {

		require '../controllers/' . $controller . '.php';

	} elseif ( ! empty($url_1) && $sub1==$url_1 && ! isset($url_2) && $sub2=='' ) {

		require '../controllers/' . $controller . '.php';

	}

}

// Render 'controllers/pages/home.php' as Homepage
if ( $_SERVER['REQUEST_URI'] == '/' . SUB_PATH ) {

	require '../controllers/home.php';

}

/**
 * Manual Routing
 * Set first substring after /public/ path as the first argument.
 * Set second substring after /public/ path as the second argument.
 * Set controller in 'controllers' folder as the third argument.
 * Exclude .php extension in $controller argument.
 */

url_route('home', '', 'home');
url_route('welcome', '', 'welcome');
url_route('error', '', 'error');

// Browse 'http://localhost/basicphp/public/sample/route'
// Based on the controller, only 2 parameters can be set after /route
// Example: 'http://localhost/basicphp/public/sample/route/1/2'

url_route('sample', 'route', 'sample-route');

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
