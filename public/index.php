<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/functions.php';
$config = require_once __DIR__.'/../config/config.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/Application/views',
));

$app['storage'] = $app->share(function () use ($config) {
    $user = $config['database']['mysql']['db_user'];
    $pass = $config['database']['mysql']['db_pass'];
    $name = $config['database']['mysql']['db_name'];
    $host = $config['database']['mysql']['db_host'];

    return new \Fiche\Application\Infrastructure\DbPdoConnector($user, $pass, $name, $host, 'mysql');
});

$app->get('/', function(Request $request) use ($app) {
    return getContentFromController($app, $request);
});

$app->match('/{controller}', function($controller, Request $request) use ($app) {
    return getContentFromController($app, $request, $controller);
});

$app->match('/{controller}/{method}', function($controller, $method, Request $request) use ($app) {
    return getContentFromController($app, $request, $controller, $method);
});

$app->match('/{controller}/{method}/{params}', function($controller, $method, $params, Request $request) use ($app) {
    return getContentFromController($app, $request, $controller, $method, $params);
});

$app->run();
