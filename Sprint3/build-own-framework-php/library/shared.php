<?php
/*
 ** Check if environment is development and display errors
 */
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('log_errors', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}
/*
** Check for magic Quotes and remove them
*/

//function stripSlashesDeep($value) {
//    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
//    return $value;
//}

// deprecated in php 8.0 don't worry about magic quotes in php 8 !
//function removeMagicQuotes() {
//    if( get_magic_quotes_gpc()) {
//        $GET = stripSlashesDeep($_GET);
//        $POST = stripSlashesDeep($_POST);
//        $_COOKIE = stripSlashesDeep($_COOKIE);
//    }
//}

/**
 * Check register globals and remove them
 **/


/**
 * In modern PHP versions (5.4 and beyond), register_globals is already disabled
 * by default, meaning there's no need to manually "unset" these variables
 *  because they don't exist.
 */
//function unregisterGlobals(): void
//{
//    if(ini_get('register_globals')) {
//        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST','_SERVER','_ENV','_FILES');
//        foreach($array as $value) {
//            foreach($GLOBALS[$value] as $key => $var) {
//                if ($var === $GLOBALS[$key]) {
//                   unset($GLOBALS[$value]);
//                }
//            }
//        }
//    }
//}

/**
 ** Main call function
 */

function callHook() {
    global $url;
    var_dump($url);
    $urlArray = array();
    $urlArray = explode("/",$url);

    $controller = $urlArray[0];
    array_shift($urlArray);
    $action = $urlArray[0];
    array_shift($urlArray);
    $queryString = $urlArray;

    $controllerName = $controller;
    $controller = ucwords($controller);
    $model = rtrim($controller, 's');
    $controller .= 'Controller';
    $dispatch = new $controller($model,$controllerName,$action);

    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch,$action),$queryString);
    } else {
        /* Error Generation Code Here */
    }
}

/*
* AutoLoad any classes that are required
*/

function autoload($className): void
{
    if(file_exists(ROOT.DS.'library'.DS.strtolower($className). '.class.php')) {
        require_once (ROOT.DS.'library'.DS.strtolower($className). '.class.php');
    }else if(file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS .strtolower($className) . '.php')) {

        require_once (ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if(file_exists(ROOT.DS.'application' . DS . 'models'.DS.strtolower($className) . '.php')) {
        require_once (ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    }else {
        /* ERROR GENERATION HERE */
        echo "Class '$className' not found in any of the expected directories: library, controllers, models.";
    }
}

/*
 * register the autoload
 */
spl_autoload_register('autoload');

setReporting();
//removeMagicQuotes();  // now optional in PHP 8,  we can remove it if we don't use magic quotes
//unregisterGlobals(); //  register globals is already disabled in php 8 , no need to miss with it .
callHook();
