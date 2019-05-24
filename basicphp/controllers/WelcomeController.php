<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class WelcomeController
{

	public function index()
	{

		// Set data to pass as variables
		$param1 = url_value(1);
		$page_title = 'Welcome!';

		$data = compact('param1', 'page_title');
		view('welcome', $data);

	}

}