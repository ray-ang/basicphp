<?php

/**
 * BasicPHP - A PHP Nano-Framework for Decoupled Application Logic and Presentation
 *          - The aim of the project is for developers to build applications that
 *          - are framework-independent by decoupling the Model, View and Controller
 *          - from any framework, making the application portable and compatible with
 *          - the developer's framework of choice or plain PHP.
 *          -
 *          - BasicPHP's functions library (functions.php) can be embedded in the
 *          - chosen framework's front controller, and the (1) classes, (2) models,
 *          - (3) views, and (4) controllers folders copied one folder above the front
 *          - controller file of the chosen framework.
 *
 * @package  BasicPHP
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

// Register the start time as a float value
$time_start = floatval(microtime());

 // Start sessions
session_start();

// Functions library
require_once '../functions.php';

// Bootstrap configuration
require_once '../config.php';

// Routing configuration
require_once '../routes.php';

// // Register the end time as a float value
// $time_end = floatval(microtime());
// // Compute the elapsed time
// $time_lapse = $time_end - $time_start;
// echo 'Start: ' . $time_start . '<br/>';
// echo 'End: ' . $time_end . '<br/>';
// echo 'Lapse Time: ' . $time_lapse . '<br/>';
// // Compute average load speed. Set $_SESSION['speed'] as an array.
// if (! isset($_SESSION['speed'])) { $_SESSION['speed'] = []; }
// $_SESSION['speed'][] = $time_lapse;
// // Average load speed
// echo 'The average load speed is: ' . (array_sum($_SESSION['speed'])/count($_SESSION['speed']));
// var_dump($_SESSION['speed']);
// // Place a comment on session_destroy() to start computing average load speed.
// session_destroy();