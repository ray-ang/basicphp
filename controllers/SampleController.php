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
		$param1 = Basic::segment(3);
		$param2 = Basic::segment(4);
		$param3 = Basic::segment(5);
		$person = ['James'=>"23", 'Joseph'=>"23", 'Chris'=>"35"];
		$page_title = 'Sample Route Page';

		// Display page
		if ( is_numeric(Basic::segment(3)) && is_numeric(Basic::segment(4)) && Basic::segment(5) == FALSE ) {

			$data = compact('page_title', 'param1', 'param2', 'param3', 'person');
			Basic::view('sample_route', $data);

		} elseif ( ! is_numeric(Basic::segment(3)) || ! is_numeric(Basic::segment(4)) || Basic::segment(5) !== FALSE ) {

			$error_message = 'You can place only 2 numbers as parameters after the /route string, such as /route/1/2 .';
			$data = compact('page_title', 'error_message');
			Basic::view('error', $data);

		}

	}

}