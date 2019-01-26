<?php

/**
 * Page Builder Plugin
 * This class constructs the template. The variables can then be passed to
 * the View using compact() function as $data in the Controller.
 * @package  Page Builder
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 * @param    string $view - View file handling the layout (Exclude .php)
 * @param    variable $data - Data array of variables (i.e. $data = compact())
 */

class Page

{

	public static function view($view, $data = null)

	{

		// Show Header and Menu
		require '../views/template/header.php';
		require '../views/template/menu.php';

		// Render Page View
		require '../views/' . $view . '.php';

		// Show Footer
		require '../views/template/footer.php';

	}

}