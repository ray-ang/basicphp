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

// Start sessions
session_start();

// Functions library
require_once '../functions.php';

// Bootstrap configuration
require_once '../config.php';

// Routing configuration
require_once '../routes.php';