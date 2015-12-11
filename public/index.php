<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/functions.php';
$config = require_once __DIR__.'/../config/config.php';

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
