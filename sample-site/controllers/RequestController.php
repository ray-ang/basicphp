<?php

class RequestController
{

	public function index()
	{
		// Execute if "Search" button is clicked
		if ( isset($_POST['search-patient']) ) {
			$page_title = 'API Response';
			$input = ['search' => $_POST['patient-name']]; // $data_input as an array
			$output = Basic::apiCall('POST', Basic::baseUrl() . 'api/request', $input, 'enc-v1.VWZUSXNEUVdQVmlPbnVVTVRDZkxibC9aM3YwT21raVhpdXRBNGZoR1dsUjllUT09.iJPEzvBUYueIhg0c8VD5Ag==.a1ycb+X3teBNAlAjQAQe/w==');

			Basic::view('request', compact('page_title', 'output'));
		} else {
			$page_title = 'API Request';

			Basic::view('request', compact('page_title'));
		}
	}

}