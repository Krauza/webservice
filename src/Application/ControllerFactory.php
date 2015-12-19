<?php
namespace Fiche\Application;

use Fiche\Application\Exceptions\ActionNotExists;
use Fiche\Application\Exceptions\ControllerNotExists;

class ControllerFactory
{
    static public function getController($controller, $storage, $request)
    {
        $controllerName = self::prepareControllerName($controller);

        if(file_exists(__DIR__."/Controllers/$controllerName.php")) {
            $controllerClass = "Fiche\\Application\\Controllers\\$controllerName";

            if(class_exists($controllerClass)) {
                return new $controllerClass($storage, $request);
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

    static public function prepareControllerName(string $controller)
    {
        return implode('', self::convertFromUnderLines($controller)) . 'Controller';
    }

    static public function prepareMethodName(string $method)
    {
        $method = self::convertFromUnderLines($method);
        $method[0] = strtolower($method[0]);

        return implode('', $method);
    }

    static public function convertFromUnderLines(string $string)
    {
        return array_map(function($el) {
            return ucfirst($el);
        }, explode('_', $string));
    }
}
