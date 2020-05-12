<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */

class EncryptionController
{

	public function index()
	{

		$page_title = 'Data Encryption';

		$data = compact('page_title');
		Basicphp::view('encryption', $data);

	}

}