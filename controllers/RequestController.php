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

		/**
		 * BasicPHP - Rest API
		 *
		 * @author  Raymund John Ang <raymund@open-nis.org>
		 * @license MIT License
		 */

		// Execute if "Search" button is clicked
		if ( isset($_POST['search-patient']) ) {

			$page_title = 'API Response';
			
			$data_input = ['search' => $_POST['patient-name']]; // $data_input as an array
			$data_output = Basic::api_call('POST', BASE_URL . 'api', $data_input, 'Peter', 12345);

			$data = compact('page_title', 'data_output');
			Basic::view('request', $data);

		} else {

			$data = ['page_title' => 'API Request'];
			Basic::view('request', $data);

		}

	}

}