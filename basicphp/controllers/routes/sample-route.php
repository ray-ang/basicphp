<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

// Set sub-url string as variable in controller
$param1 = url_value(3);
$param2 = url_value(4);
$param3 = url_value(5);

// Show header and menu
require '../template/header.php';
require '../template/menu.php';

// Limit valid sub-url string
if (isset($param3)) {

	// Set $error_message for the error page
	$error_message = 'You can only set 2 parameters.';

	// Render error page
	require '../views/pages/404_error.php';

}

// Display page
if (! isset($param3)) {

	// Render sample_route view
	// Use variables inside view using native PHP templating
	require '../views/routes/sample_route.php';

}

// Show footer
require '../template/footer.php';

?>