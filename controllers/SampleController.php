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
		$param1 = url_value(3);
		$param2 = url_value(4);
		$param3 = url_value(5);
		$person = ['James'=>"23", 'Joseph'=>"23", 'Chris'=>"35"];
		$page_title = 'Sample Route Page';

		// Display page
		if ( is_numeric(url_value(3)) && is_numeric(url_value(4)) && url_value(5) == false ) {

			$data = compact('param1', 'param2', 'param3', 'person', 'page_title');
			view('sample_route', $data);

		} elseif ( ! is_numeric(url_value(3)) || ! is_numeric(url_value(4)) || url_value(5) !== false ) {

			$error_message = 'You can place only 2 numbers as parameters after the /route string, such as /route/1/2 .';
			$data = compact('error_message', 'page_title');
			view('error', $data);

		}

	}

}