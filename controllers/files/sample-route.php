<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

// Set sub-url strings as variables
$param1 = url_value(3);
$param2 = url_value(4);
$param3 = url_value(5);

// Set array as a variable and use to render view
$person = array('James'=>"23", 'Joseph'=>"23", 'Chris'=>"35");

$data = compact('param1', 'param2', 'param3', 'person');

// Limit valid sub-url string
if (isset($param3)) {

	// Set $error_message for the error page
	$error_message = 'You can only set 2 parameters.';

	$data = compact('error_message');

	View::page('error', $data);

}

// Display page
if (! isset($param3)) {

	View::page('sample_route', $data);

}
