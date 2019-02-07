<?php

/**
 * Database Connection Plugin
 * This class holds database credentials and connection.
 * @package  Database Connection Plugin
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

class Database

{

	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "basicphp";

	public function conn()

	{

		$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_PERSISTENT, true);

		return $conn;

	}

}