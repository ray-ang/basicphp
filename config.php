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
| When working in a development environment, define 'ENVIRONMENT' as
| 'development'. When working in a production environment, define
| 'ENVIRONMENT' as 'production'. Error reporting is turned ON in development,
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
| Firewall Settings
|--------------------------------------------------------------------------
*/

// Turn firewall ON or OFF as TRUE or FALSE.
define('FIREWALL_ON', TRUE);
// List of allowed IP addresses in an array
define('ALLOWED_IP_ADDR', ['::1']);
// Set URI Whitelisted Characters
define('URI_WHITELISTED', '\w\/\.\-\_\?\=\&');
// Blacklisted $_POST and post body characters. '\' blacklisted by default.
define('POST_BLACKLISTED', '\<\>\;\#\\$');

/*
|--------------------------------------------------------------------------
| Enforce SSL/HTTPS
|--------------------------------------------------------------------------
*/

define('ENFORCE_SSL', FALSE);

/*
|--------------------------------------------------------------------------
| Configuration for Encryption and Decryption
|--------------------------------------------------------------------------
*/

// Passphrase for key derivation
define('PASS_PHRASE', '12345');
// Cipher method
define('CIPHER_METHOD', 'aes-256-ctr');

/** Limit to AES mode: CBC, CTR or GCM */
if ( ! preg_match('/(aes-256-cbc|aes-256-ctr|aes-256-gcm)/i', CIPHER_METHOD) ) {
    exit ('<strong>Warning: </strong>Only CBC, CTR and GCM modes of AES are supported.');
}

/*
|--------------------------------------------------------------------------
| Set BASE_URL
|--------------------------------------------------------------------------
*/

$http_protocol = (ENFORCE_SSL == FALSE) ? 'http://' : 'https://';
$subfolder = (! empty(dirname($_SERVER['SCRIPT_NAME']))) ? dirname($_SERVER['SCRIPT_NAME']) : '';

define('BASE_URL', $http_protocol . $_SERVER['SERVER_NAME'] . $subfolder . '/');

/*
|--------------------------------------------------------------------------
| Number of subdirectories from hostname to index.php
|--------------------------------------------------------------------------
*/

define('SUB_DIR', substr_count($_SERVER['SCRIPT_NAME'], '/')-1);

/*
|--------------------------------------------------------------------------
| Set Homepage Controller@method
|--------------------------------------------------------------------------
*/

define('HOME_PAGE', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Set Controller Suffix
|--------------------------------------------------------------------------
|
| If you are using 'ClassController' convention, set to 'Controller'.
|
*/

define('CONTROLLER_SUFFIX', 'Controller');

/*
|--------------------------------------------------------------------------
| Set Default Method
|--------------------------------------------------------------------------
|
| If the second URL string is empty, set this method as the default method.
|
*/

define('METHOD_DEFAULT', 'index');