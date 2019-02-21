<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

use Basic_View as View;

class ErrorController

{

	public function index()

	{

		$data = ['page_title' => 'Error'];

		View::page('error', $data);

	}

}