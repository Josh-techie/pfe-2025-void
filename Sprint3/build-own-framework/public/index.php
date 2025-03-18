<?php
// public/index.php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

// Load the configuration file
require_once(ROOT . DS . 'config' . DS . 'config.php');

// Autoload classes
spl_autoload_register(function ($class) {
    $file = ROOT . DS . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Set up URL - Check if URL parameter exists and sanitize it
$url = isset($_GET['url']) ? filter_var($_GET['url'], FILTER_SANITIZE_URL) : '';

// Include bootstrap file
// require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');

/** Check if environment is development and display errors **/
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

/** Check for Magic Quotes and remove them **/
function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    // Magic quotes were removed in PHP 7.4+ and don't exist in PHP 8.0+
    // This function is kept for backward compatibility but does nothing in modern PHP
    if (version_compare(PHP_VERSION, '7.4.0', '<') && function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $_GET    = stripSlashesDeep($_GET);
        $_POST   = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}
/** Check register globals and remove them **/
function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function **/
function callHook() {
    global $url;
    $urlArray = array();
    $urlArray = explode("/", $url);
    
    // Handle empty controller case
    $controller = !empty($urlArray[0]) ? $urlArray[0] : 'index';
    array_shift($urlArray);
    
    // Handle empty action case
    $action = !empty($urlArray[0]) ? $urlArray[0] : 'index';
    array_shift($urlArray);
    
    $queryString = $urlArray;
    $controllerName = $controller;
    $controller = ucwords($controller);
    $model = rtrim($controller, 's');
    $controller .= 'Controller';
    
    // Check if controller class exists
    if (class_exists($controller)) {
        $dispatch = new $controller($model, $controllerName, $action);
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch, $action), $queryString);
        } else {
            // Error: Action not found
            header("HTTP/1.0 404 Not Found");
            echo "Action not found: $action";
        }
    } else {
        // Error: Controller not found
        header("HTTP/1.0 404 Not Found");
        echo "Controller not found: $controllerName";
    }
}

/** Autoload any classes that are required **/
function customAutoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } else {
        // Error: Class not found
        // Just silently fail, as this might be a PHP internal class
    }
}

// Register the custom autoload function
spl_autoload_register('customAutoload');

// Run application
setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();