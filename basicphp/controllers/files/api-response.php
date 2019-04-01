<?php

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
$_POST = json_decode($_POST['json'], true);

// Authentication: Check if with valid user and license key.
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && in_array(['user' => $_POST['user'], 'key' => $_POST['key']], $license_key) ) {

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