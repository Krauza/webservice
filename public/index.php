<?php

require_once __DIR__.'/../vendor/autoload.php';

use Fiche\Application\ControllerFactory;
use Fiche\Application\Exceptions\ControllerNotExists;
use Fiche\Application\Exceptions\ActionNotExists;

$app = new Silex\Application();

$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/Application/views',
));

function getContentFromController(Silex\Application $app, string $controller = 'base', string $action = 'index', $params = null) {
    try {
        $controllerInstance = ControllerFactory::getController($controller);
        $template = $app['twig']->render("/$controller/$action.html.twig", ControllerFactory::callMethod($controllerInstance, $action, $params));
    } catch(ControllerNotExists $e) {
        $template = $app['twig']->render('error-404.html', array('content' => ''));
    } catch(ActionNotExists $e) {
        $template = $app['twig']->render('error-404.html', array('content' => ''));
    }

    return $template;
}

$app->get('/', function() use ($app) {
    return getContentFromController($app);
});

$app->get('/{controller}', function($controller) use ($app) {
    return getContentFromController($app, $controller);
});

$app->get('/{controller}/{method}', function($controller, $method) use ($app) {
    return getContentFromController($app, $controller, $method);
});

$app->get('/{controller}/{method}/{params}', function($controller, $method, $params) use ($app) {
    return getContentFromController($app, $controller, $method, $params);
});

$app->run();
