<?php

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');

class Bootstrap {
    public static function run($url) {
        // Routing logic here
        $urlParts = explode('/', $url);
        $controllerName = isset($urlParts[0]) && !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ItemsController'; //Default Controller
        $actionName     = isset($urlParts[1]) && !empty($urlParts[1]) ? $urlParts[1] : 'viewall'; //Default action
        $params         = array_slice($urlParts, 2); // Any additional parameters

        $controllerFile = ROOT . DS . 'application' . DS . 'controllers' . DS . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName($controllerName, str_replace('Controller', '', $controllerName), $actionName); // adjust params to match your constructor

            if (method_exists($controller, $actionName)) {
                call_user_func_array(array($controller, $actionName), $params);
            } else {
                die("Action {$actionName} not found in controller {$controllerName}"); //Or handle gracefully
            }
        } else {
            die("Controller {$controllerName} not found"); // Or handle gracefully with a 404
        }

    }
}
?>