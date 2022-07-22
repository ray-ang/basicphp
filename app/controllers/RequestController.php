<?php

class RequestController
{

	public function index()
	{
		// Execute if "Search" button is clicked
		if (isset($_POST['search-patient'])) {
			$page_title = 'API Response';
			$input = ['search' => $_POST['patient-name']]; // $data_input as an array
			$output = Basic::apiCall(Basic::baseUrl() . 'api/request', 'POST', $input, AUTH_TOKEN);

			Basic::view('request', compact('page_title', 'output'));
		} else {
			$page_title = 'API Request';

			Basic::view('request', compact('page_title'));
		}
	}
}
