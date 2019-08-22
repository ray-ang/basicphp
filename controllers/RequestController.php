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

			// $data_input as an array containing $_POST keys and values
			$data_input = ['search' => $_POST['patient-name']];

			$data_output = api_call('POST', 'http://localhost/basicphp/public/api/response', $data_input, 'Peter', 12345);
			$page_title = 'API Response';

			$data = compact('data_output', 'page_title');
			view('request', $data);

		} else {

			$data = ['page_title' => 'API Request'];
			view('request', $data);

		}

	}

}
