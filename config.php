<?php

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
	$class_folders[] = 'models';
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
| Render Homepage
|--------------------------------------------------------------------------
*/

if ( ! isset($_GET['url-path']) ) {

	$class_object = new HomeController();
	return $class_object->index();

}
