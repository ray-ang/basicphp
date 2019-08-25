<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class ApiController
{

	public function index()
	{

		/**
		 * BasicPHP - Rest API
		 *
		 * @author  Raymund John Ang <raymund@open-nis.org>
		 * @license MIT License
		 */

		// $license_key as an array of valid license keys
		$license_key = [];
		$license_key[] = ['user' => 'John', 'key' => 12345];
		$license_key[] = ['user' => 'James', 'key' => 12345];
		$license_key[] = ['user' => 'Peter', 'key' => 12345];
		$license_key[] = ['user' => 'Samuel', 'key' => 12345];
		$license_key[] = ['user' => 'Joseph', 'key' => 12345];

		// $data as an array of patient information from the EMR
		$data = [];
		$data[] = ['patient' => 'John', 'age' => 32];
		$data[] = ['patient' => 'Peter', 'age' => 43];
		$data[] = ['patient' => 'James', 'age' => 22];
		$data[] = ['patient' => 'Samuel', 'age' => 28];
		$data[] = ['patient' => 'Joseph', 'age' => 65];

		// Convert JSON to an array and set as $_POST
		// $_POST = json_decode($_POST['json'], true);

		// Convert POSTed JSON to an array and set as $_POST
		$_POST = json_decode(file_get_contents("php://input"), true);

		// Retrieve username and password from CURLOPT_USERPWD option
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		// Authentication: Check if with valid user and license key.
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && in_array(['user' => $username, 'key' => $password], $license_key) ) {

			foreach ( $data as $row ) {

				// Add to $data_output array if patient's name contains search string
				if ( stristr($row['patient'], $_POST['search']) == true ) {

					// Change $data_output key names to hide database column names
					$data_output[] = ['name'=>$row['patient'], 'age'=>$row['age']];

				}

			}

			if (! empty($data_output)) {

				api_response($data_output, 'Your search has some results.');

			} else {

				api_response($data=null, 'No Patient name found on search.');

			}

		} else {

			$message = 'You do not have the right credentials.';

			api_response($data=null, $message);

		}

	}

}