<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

class Cont_Sample

{

	public function route()

	{

		// Set sub-url strings as variables
		$param1 = url_value(3);
		$param2 = url_value(4);
		$param3 = url_value(5);

		// Set array as a variable and use to render view
		$person = array('James'=>"23", 'Joseph'=>"23", 'Chris'=>"35");

		$data = compact('param1', 'param2', 'param3', 'person');

		// Limit valid sub-url string
		if (isset($param3)
			OR (! isset($param3) && isset($param1) && ! is_numeric($param1))
			OR (! isset($param3) && isset($param2) && ! is_numeric($param2))) {

			// Set $error_message for the error page
			$error_message = 'You can only set 2 numbers as parameters.';

			$data = compact('error_message');

			Page::view('error', $data);

		}

		// Display page
		if (! isset($param3) && ! isset($param1)
			OR (! isset($param3) && isset($param1) && is_numeric($param1) && ! isset($param2))
			OR (! isset($param3) && isset($param1) && is_numeric($param1) && isset($param2) && is_numeric($param2))) {

			Page::view('sample_route', $data);

		}

	}

}