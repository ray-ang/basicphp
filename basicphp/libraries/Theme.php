<?php

/**
 * Theme Builder Plugin
 * This class constructs the template and passes variables using compact() as $data.
 * @package  Theme Builder
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 * @param    string $view - Controller file handling the page or route (Exclude .php)
 * @param    variable $data - Data payload (i.e. $data = compact())
 */

class Theme

{

	public static function page($view, $data = null)

	{

		// Show Header and Menu
		require '../template/header.php';
		require '../template/menu.php';

		// Render Page View
		require '../views/pages/' . $view . '.php';

		// Show Footer
		require '../template/footer.php';

	}

	public static function route($view, $data = null)

	{

		// Show Header and Menu
		require '../template/header.php';
		require '../template/menu.php';

		// Render Route View
		require '../views/routes/' . $view . '.php';

		// Show Footer
		require '../template/footer.php';

	}

}