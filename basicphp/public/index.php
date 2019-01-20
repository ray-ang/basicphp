<?php

/**
 * BasicPHP - A PHP Micro-Framework
 *
 * @package  BasicPHP
 * @author   Raymund John Ang <raymund@open-nis.org>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Autoload classes. User-defined classes should be placed in the 'classes'
| folder. External library classes should be placed in the 'libraries' folder.
|
*/

// Autoload user-defined classes
spl_autoload_register(function ($class_name) {

	$filename = '../classes/' . $class_name . '.php';

	if (file_exists($filename) && is_readable($filename)) {

		require_once '../classes/' . $class_name . '.php';

	}

});

// Autoload external library classes
spl_autoload_register(function ($class_name) {

	$filename = '../libraries/' . $class_name . '.php';

	if (file_exists($filename) && is_readable($filename)) {

		require_once '../libraries/' . $class_name . '.php';

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
| 'http://example.com' or 'https://example.com'.
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
| If substring after /public/ path is a PHP file under 'controllers/pages'
| folder, and there is no substring after that - separated by '/', load the
| page controller file. If the file does not exist, load the error page.
| Substrings are defined as characters inside and separated by '/'.
| 
| If there are two substrings after the /public/ path separated by a '/',
| load the route controller file in the 'controllers/routes' folder.
| 
| Functions url_value() and url_route() are used to retrieve the value of
| the URL substring, and to implement routing if there are two substrings
| after the /public/ path. These functions can be placed as a separate class
| method and autoloaded for use.
| 
| Note: If 'public' folder is the DocumentRoot, the two substrings will be
| in reference to the domain name, not the /public/ path.
|
*/

/**
 * Get URL substring after /public/ path separated by '/'
 * @param integer $position // substring position from /public/ path
 */

function url_value($position)

{

    $url = explode('/', $_SERVER['REQUEST_URI']);

    $number = $position + SUB_ORDER;

    if (isset($url[$number])) $string = $url[$number];

    if (isset($string)) return $string;

}

/**
 * Load 'controllers/routes' PHP file if two substrings are set
 * @param string $sub1 // first substring after /public/ path
 * @param string $sub2 // second substring after /public/ path
 * @param string $controller // controller file inside 'controllers/routes'
 * Exlude .php extension from $controller argument.
 */

function url_route($sub1, $sub2, $controller)

{

	if ( url_value(1)==$sub1 && url_value(2)==$sub2 )  {

		require '../controllers/routes/' . $controller . '.php';

	}

}

// Render 'controllers/pages/home.php' as Homepage
if ( $_SERVER['REQUEST_URI'] == '/' . SUB_PATH ) {

	require '../controllers/pages/home.php';

} elseif ($_SERVER['REQUEST_URI'] !==  SUB_PATH . '/') {

	// Set $filename as {first_substring}.php
	$filename = '../controllers/pages/' . url_value(1) . '.php';

	// Set $url_value_2 as second substring after /public/ path
	$url_value_2 = (url_value(2));

	/**
	 * Automatic Routing
	 * If URL substring next to /public/ path is a controller file, and
	 * there is no second substring, load controller file with the same
	 * name as the first substring. This is used to create pages.
	 */

	if (file_exists($filename) && ! isset($url_value_2)) {

	    require $filename;

	}

	// Show Error page if first URL substring is not a controller file
	if (! file_exists($filename) && ! isset($url_value_2)) {

		// Set $error_message for the error page
		$error_message = 'This is not a valid webpage.';

		require '../controllers/pages/error.php';

	}

}

/**
 * Manual Routing
 * Set first substring after /public/ path as the first argument.
 * Set second substring after /public/ path as the second argument.
 * Set controller in 'controllers/routes' folder as the third argument.
 * Exclude .php extension in $controller argument.
 */

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

	echo '<h4>Error 404. Page not found. This is an Invalid URL.</h4>';

}
