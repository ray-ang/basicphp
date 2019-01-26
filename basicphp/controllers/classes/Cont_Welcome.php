<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

class Cont_Welcome

{

	public function index()

	{

		// Set variable in controller
		$param1 = url_value(1);

		$data = compact('param1');

		Page::view('welcome', $data);

	}

}