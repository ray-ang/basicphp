<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class SampleController
{

	public function route()
	{

		// Set data to pass as variables
		$param1 = url_value(2);
		$param2 = url_value(3);
		$param3 = url_value(4);
		$person = ['James'=>"23", 'Joseph'=>"23", 'Chris'=>"35"];
		$page_title = 'Sample Route Page';

		// Display page
		if (! isset($param3) && ! isset($param1)
			OR (! isset($param3) && isset($param1) && is_numeric($param1) && ! isset($param2))
			OR (! isset($param3) && isset($param1) && is_numeric($param1) && isset($param2) && is_numeric($param2))) {

			$data = compact('param1', 'param2', 'param3', 'person', 'page_title');
			view('sample_route', $data);

		}

		// Limit valid sub-url string
		if (isset($param3)
			OR (! isset($param3) && isset($param1) && ! is_numeric($param1))
			OR (! isset($param3) && isset($param2) && ! is_numeric($param2))) {

			// Set $error_message for the error page
			$error_message = 'You can only set 2 numbers and only have 2 parameters.';

			$data = compact('error_message', 'page_title');
			view('error', $data);

		}

	}

}
