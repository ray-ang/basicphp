<?php

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

	$class_object = new HomeController();
	$class_object->index();

}

/**
 * Manual Routing Using Class-based Controllers
 * Set first substring after /public/ path as the first argument.
 * Set second substring after /public/ path as the second argument.
 * Set class name as the third argument.
 * Set instance method as the fourth argument.
 */

// URL routing for pages using Class-based controllers
route_class('GET', 'home', null, 'HomeController@index');
route_class('GET', 'welcome', null, 'WelcomeController@index');
route_class('GET', 'error', null, 'ErrorController@index');
route_class('GET', 'request', null, 'RequestController@index');
route_class('POST', 'request', null, 'RequestController@index');

/**
 * Browse 'http://localhost/basicphp/public/sample/route'
 * Based on the controller, only 2 parameters can be set after /route/
 * Example: 'http://localhost/basicphp/public/sample/route/1/2'
 */

// URL routing for routes using Class-based controllers
route_class('GET', 'sample', 'route', 'SampleController@route');
route_class('GET', 'post', 'list', 'PostController@list');
route_class('GET', 'post', 'view', 'PostController@view');
route_class('POST', 'post', 'view', 'PostController@view');
route_class('GET', 'post', 'add', 'PostController@add');
route_class('POST', 'post', 'add', 'PostController@add');
route_class('GET', 'post', 'edit', 'PostController@edit');
route_class('POST', 'post', 'edit', 'PostController@edit');

// URL routing for API using File-based controller
route_file('POST', 'api', 'response', 'api-response');

/**
 * Below are examples of File-based Controllers.
 * To ensure proper decoupling, but still adhere to conventional method of
 * assigning a Controller to a specific route, it is recommended to use
 * class-based Controllers instead.
 */

// route_file('GET', 'home', null, 'home');
// route_file('GET', 'welcome', null, 'welcome');
// route_file('GET', 'error', null, 'error');
// route_file('GET', 'sample', 'route', 'sample-route');