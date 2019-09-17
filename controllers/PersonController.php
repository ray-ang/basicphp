<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; load models, and
 * include files. The variables can then be used in the view file.
 */


class PersonController
{

	protected $person = [['id' => 1, 'name' => 'Anthony'],
						['id' => 2, 'name' => 'Bernadette'],
						['id' => 3, 'name' => 'Charlie'],
						['id' => 4, 'name' => 'David'],
						['id' => 5, 'name' => 'Erica']];
	
	public function list()
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			api_response($this->person, 'This is a list of person ID\'s and names.');
		} else { header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed"); }

	}

	public function view()
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

			if ( url_value(3) !== FALSE && is_numeric(url_value(3)) ) {

				foreach ($this->person as $person) {

					if ( $person['id'] == url_value(3) ) {
						$person_find[] = $person;
					}

				}

				if (!empty($person_find)) api_response($person_find, 'A person with that ID number exists.');

				if (empty($person_find)) api_response(NULL, 'No person exists with that ID number.');

			} else {

				api_response(NULL, 'Please indicate ID number.');
				
			}

		} else { header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed"); }

	}
	
	public function add()
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

			$_POST = json_decode(file_get_contents("php://input"), TRUE);

			$this->person[] = $_POST;
			api_response($this->person, 'A person was added to the list.');

		} else { header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed"); }

	}

	public function edit()
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

			if ( url_value(3) !== FALSE && is_numeric(url_value(3)) ) {

				foreach ($this->person as $person) {

					if ( $person['id'] == url_value(3) ) {
						$person_find[] = $person;
					}

				}

				if (!empty($person_find)) api_response($person_find, 'A person with that ID number was updated.');

				if (empty($person_find)) api_response(NULL, 'No person was updated.');

			} else {

				api_response(NULL, 'Please indicate ID number.');
				
			}

		} else { header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed"); }

	}

	public function delete()
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

			if ( url_value(3) !== FALSE && is_numeric(url_value(3)) ) {

				foreach ($this->person as $person) {

					if ( $person['id'] == url_value(3) ) {
						$person_find[] = $person;
					}

				}

				if (!empty($person_find)) api_response($person_find, 'A person with that ID number was deleted.');

				if (empty($person_find)) api_response(NULL, 'No person was deleted.');

			} else {

				api_response(NULL, 'Please indicate ID number.');
				
			}

		} else { header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed"); }

	}

}