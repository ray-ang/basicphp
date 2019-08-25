<?php

/*
|--------------------------------------------------------------------------
| Start Session
|--------------------------------------------------------------------------
*/

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

// Add class folders to autoload
$class_folders[] = 'classes';
$class_folders[] = 'models';
$class_folders[] = 'controllers';

define('AUTOLOAD_CLASSES', $class_folders);

spl_autoload_register(function ($class_name) {

	foreach (AUTOLOAD_CLASSES as $folder) {

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

define('ENVIRONMENT', 'development');

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        break;
    case 'production':
        error_reporting(0);
        break;
}

/*
|--------------------------------------------------------------------------
| Set BASE_URL
|--------------------------------------------------------------------------
|
| Define 'BASE_URL' as the domain with '/' at the end, such as
| 'http://example.com/' or 'https://example.com/'.
|
*/

define('BASE_URL', 'http://localhost/basicphp/public/');

/*
|--------------------------------------------------------------------------
| Set Homepage
|--------------------------------------------------------------------------
*/

define('HOME_PAGE', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Set Controller Suffix
|--------------------------------------------------------------------------
*/

define('CONTROLLER_SUFFIX', 'Controller');

/*
|--------------------------------------------------------------------------
| Set Default Method
|--------------------------------------------------------------------------
*/

define('METHOD_DEFAULT', 'index');