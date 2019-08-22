<?php

/*
|--------------------------------------------------------------------------
| Set Routing Configuration
|--------------------------------------------------------------------------
| 
| If there are two substrings after the BASE_URL separated by a '/', load
| the class-based Controller in the 'controllers/' folder.
| 
| Functions url_value() and route_class() are used to retrieve the value of
| the URL substring, and to implement routing if there are two substrings
| after the BASE_URL.
| 
| Note: If 'public/' folder is the DocumentRoot, the two substrings will be
| in reference after the domain name, not the /public/ path.
|
*/

/**
 * Manual Routing Using Class-based Controllers
 * Set HTTP request method as the first argument.
 * Set first substring after the BASE_URL as the second argument.
 * Set second substring after the BASE_URL as the third argument.
 * Set ClassController@method as the fourth argument.
 */

/* URL routing for pages using Class-based controllers */
route_class('GET', 'home', null, 'HomeController@index');
route_class('GET', 'welcome', null, 'WelcomeController@index');
route_class('GET', 'request', null, 'RequestController@index');
route_class('POST', 'request', null, 'RequestController@index');

/**
 * Browse 'http://localhost/basicphp/public/sample/route'
 * Based on the controller, only 2 numbers can be set after /route/
 * Example: 'http://localhost/basicphp/public/sample/route/1/2'
 */

/* URL routing for routes using Class-based controllers */
route_class('GET', 'sample', 'route', 'SampleController@route');
route_class('GET', 'post', 'list', 'PostController@list');
route_class('GET', 'post', 'view', 'PostController@view');
route_class('POST', 'post', 'view', 'PostController@view');
route_class('GET', 'post', 'add', 'PostController@add');
route_class('POST', 'post', 'add', 'PostController@add');
route_class('GET', 'post', 'edit', 'PostController@edit');
route_class('POST', 'post', 'edit', 'PostController@edit');

/* URL routing for API's using File-based controllers */
route_file('POST', 'api', 'response', 'api-response');

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
|
| Invalid URI's include only two (3) files: the front controller (index.php),
| BasicPHP core file (core.php), and the routing configuration (routes.php).
| Any valid page rendered, even the error page, will need to require a file
| other than the front controller, core and routes files. The script below
| should be run last to avoid conflict with routing configuration.
|
*/

if ( count(get_included_files()) == 4 ) {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

	$error_message = '<h3 style="text-align: center;">Error 404. Page not found. This is an Invalid URL.</h3>';
	$page_title = 'Error 404';

	$data = compact('error_message', 'page_title');
	view('error', $data);

	// var_dump(http_response_code());

}
