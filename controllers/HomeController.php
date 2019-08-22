<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class HomeController
{

	public function index()
	{

		$data = ['page_title' => 'Starter Application'];
		view('home', $data);

	}

}
