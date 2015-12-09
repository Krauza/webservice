<?php
namespace Fiche\Application;

use Fiche\Application\Exceptions\ActionNotExists;
use Fiche\Application\Exceptions\ControllerNotExists;

class ControllerFactory
{
    static public function getController($controller)
    {
        $controller = strtolower($controller);
        $controllerName = ucfirst($controller) . 'Controller';

        if(file_exists(__DIR__."/Controllers/$controllerName.php")) {
            $controllerClass = "Fiche\\Application\\Controllers\\$controllerName";

            if(class_exists($controllerClass)) {
                return new $controllerClass;
            }
        }

        throw new ControllerNotExists();
    }

    static public function callMethod($controllerInstance, \string $method, $params = null)
    {
        if(method_exists($controllerInstance, $method)) {
            return $controllerInstance->{$method}($params);
        }

        throw new ActionNotExists();
    }
}
