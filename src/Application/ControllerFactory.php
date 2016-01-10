<?php
namespace Fiche\Application;

use Fiche\Application\Controllers\Controller;
use Fiche\Application\Exceptions\ActionNotExists;
use Fiche\Application\Exceptions\ControllerNotExists;

class ControllerFactory
{
    public static function getController($controller, $app, $request): Controller
    {
        $controllerName = self::prepareControllerName($controller);

        if (file_exists(__DIR__."/Controllers/$controllerName.php")) {
            $controllerClass = "Fiche\\Application\\Controllers\\$controllerName";

            if (class_exists($controllerClass)) {
                return new $controllerClass($app, $request);
            }
        }

        throw new ControllerNotExists();
    }

    public static function callMethod(Controller $controllerInstance, \string $method, $params = null)
    {
        $method = self::prepareMethodName($method);

        if (method_exists($controllerInstance, $method)) {
            return $controllerInstance->{$method}($params);
        }

        throw new ActionNotExists();
    }

    public static function prepareControllerName(\string $controller)
    {
        return implode('', self::convertFromUnderLines($controller)) . 'Controller';
    }

    public static function prepareMethodName(\string $method)
    {
        $method = self::convertFromUnderLines($method);
        $method[0] = strtolower($method[0]);

        return implode('', $method);
    }

    public static function convertFromUnderLines(\string $string)
    {
        return array_map(function($el) {
            return ucfirst($el);
        }, explode('-', $string));
    }
}
