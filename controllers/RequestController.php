<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class RequestController
{

	public function index()
	{
		// Execute if "Search" button is clicked
		if ( isset($_POST['search-patient']) ) {

			$page_title = 'API Response';
			$input = ['search' => $_POST['patient-name']]; // $data_input as an array
			$output = Basic::api_call('POST', BASE_URL . 'api/request', $input, 'Peter', 12345);

			$data = compact('page_title', 'output');
			Basic::view('request', $data);

		} else {

			$data = ['page_title' => 'API Request'];
			Basic::view('request', $data);
			
		}
	}

}