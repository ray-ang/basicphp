<?php

/**
 * Theme Builder Plugin
 * This class constructs the template. The variables can then be passed to
 * the View using compact() as $data in the Controller.
 * @package  Theme Builder
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 * @param    string $view - Controller file handling the page (Exclude .php)
 * @param    variable $data - Data array of variables (i.e. $data = compact())
 */

class Theme

{

	public static function page($view, $data = null)

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