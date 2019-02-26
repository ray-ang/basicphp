<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
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

		// // Disable error reporting in production
		// error_reporting(0);

		// Execute if "Search" button is clicked
		if ( isset($_POST['search-patient']) ) {

			// $data_input as an array containing $_POST keys and values
			$data_input = ['user' => 'Peter', 'age' => 23, 'state' => ['New York', 'New Jersey'], 'key' => 12345, 'search' =>$_POST['patient']];

			$data_output = call_api('POST', 'http://localhost/basicphp/public/api/response', $data_input);

			$page_title = 'API Response';

			$data = compact('data_output', 'page_title');

			view('request', $data);

		} else {

			$data = ['page_title' => 'API Request'];

			view('request', $data);

		}

	}

}