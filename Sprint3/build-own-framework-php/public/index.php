<?php

//
///**
// * Define a constant DS for the directory separator.
// * This is OS-dependent:
// * - On Windows, it will be a backslash (\).
// * - On Unix/Linux/macOS, it will be a forward slash (/).
// */
//define('DS', DIRECTORY_SEPARATOR);
//
///**
// * Define a constant ROOT to store the absolute path to the root directory of the project.
// * The ROOT constant is calculated by going up two levels from the current file's directory.
// * - dirname(__FILE__) returns the current directory of the file (index.php).
// * - Calling dirname() twice gets the root directory.
// */
//define('ROOT', dirname(dirname(__FILE__)));
//
///**
// * Retrieve the 'url' query parameter from the URL.
// * This URL parameter is used for routing to a specific page or controller in the application.
// *
// * Example usage:
// * - If the URL is 'index.php?url=about', this would capture 'about' as the $url variable.
// *
// * @var string $url The value of the 'url' parameter from the query string.
// */
//$url = $_GET['url'];
///**
// * Include the bootstrap.php file from the 'library' directory.
// * This file is responsible for initializing the application (setting up autoloaders, configuration, etc.).
// *
// * 'require_once' ensures that the file is included only once, avoiding re-inclusion errors.
// */
//require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');
//
//


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$url = $_GET['url'] ?? ''; // Use empty string if 'url' is not set
var_dump($_SERVER['REQUEST_URI']);

// Debugging: Check the GET parameters
var_dump($_GET);  // This will show if the URL parameter 'url' is passed
var_dump($url);    // This will show the value of $url




require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');

