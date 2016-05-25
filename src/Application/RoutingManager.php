<?php

namespace Fiche\Application;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Fiche\Application\Exceptions\ControllerNotExists;
use Fiche\Application\Exceptions\ActionNotExists;

class RoutingManager
{
    public static function declareRouting(Application $app)
    {
        $app->get('/', function(Request $request) use ($app) {
            return self::getContentFromController($app, $request);
        });

        $app->match('/{controller}', function($controller, Request $request) use ($app) {
            return self::getContentFromController($app, $request, $controller);
        });

        $app->match('/{controller}/{method}', function($controller, $method, Request $request) use ($app) {
            return self::getContentFromController($app, $request, $controller, $method);
        });

        $app->match('/{controller}/{method}/{params}', function($controller, $method, $params, Request $request) use ($app) {
            return self::getContentFromController($app, $request, $controller, $method, $params);
        });
    }

    private static function getContentFromController(Application $app, Request $request, string $controller = 'base', string $action = 'index', $params = null) {
        $userIsNotSigned = self::userIsNotSigned($app);
        if ($userIsNotSigned && self::pageIsOnlyForSignedUsers($controller, $action)) {
            return $app->redirect('/auth/login');
        }

        try {
            $controllerInstance = ControllerFactory::getController($controller, $app, $request);
            $response = ControllerFactory::callMethod($controllerInstance, $action, $params);

            if (is_array($response)) {
                $response['user_logged'] = !$userIsNotSigned;
                if($response['user_logged']) {
                    $response['current_user'] = $controllerInstance->getCurrentUser();
                }

                return $app['twig']->render("/$controller/$action.html.twig", $response);
            } else {
                return $response;
            }
        } catch(ControllerNotExists $e) {
            $content = 'Controller is not exists';
        } catch(ActionNotExists $e) {
            $content = 'Action is not exists';
        } catch(\Exception $e) {
            $content = 'Something went wrong... (' . $e->getMessage() . ')';
        }

        return $app['twig']->render(
            'errors/error-404.html.twig', array(
                'content' => $content,
                'user_logged' => !$userIsNotSigned
            )
        );
    }

    private static function userIsNotSigned($app)
    {
        return empty($app['session']->get('current_user_id'));
    }

    private static function pageIsOnlyForSignedUsers(string $controller, string $method)
    {
        if ($controller === 'auth' || $controller === 'base') {
            return false;
        }

        if ($controller === 'user' && $method === 'register') {
            return false;
        }

        return true;
    }
}
