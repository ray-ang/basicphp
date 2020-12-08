<?php

class RequestController
{

	public function index()
	{
		// Execute if "Search" button is clicked
		if ( isset($_POST['search-patient']) ) {
			$page_title = 'API Response';
			$input = ['search' => $_POST['patient-name']]; // $data_input as an array
			$output = Basic::apiCall('POST', BASE_URL . 'api/request', $input, 'Peter', 12345);

			Basic::view('request', compact('page_title', 'output'));
		} else {
			$page_title = 'API Request';

			Basic::view('request', compact('page_title'));
		}
	}

}