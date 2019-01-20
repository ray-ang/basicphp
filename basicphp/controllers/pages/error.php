<?php

/**
 * In the controller file, you can handle and process variables,
 * classes and functions; use if-elseif statements; handle your
 * database connection like PDO abstraction layer; and load/require
 * files. The variables can then be used in the view file.
 */

// Show header and menu
require '../template/header.php';
require '../template/menu.php';

// Render error view
require '../views/pages/error.php';

// Show footer
require '../template/footer.php';
