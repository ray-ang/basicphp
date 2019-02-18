<?php

/**
 * Condition Class Plugin
 * This class abstracts the conditions necessary for script execution.
 * If all conditions are met, the method will return "true".
 * @package  Condition Class Plugin
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

class Basic_Condition

{

	public static function ifPostAdd()

	{

		if ( isset($_POST['submit-post']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return true;

	}

	public static function ifPostEdit()

	{

		if ( isset($_POST['edit-post']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return true;

	}

	public static function ifPostDelete()

	{

		if ( isset($_POST['delete-post']) && $_POST['csrf-token'] == $_SESSION['csrf-token'] ) return true;

	}

}