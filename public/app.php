<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Fiche\Application\RoutingManager;

$app = new Silex\Application();
Request::enableHttpMethodParameterOverride();

$app['debug'] = true;
$app->register(new Silex\Provider\SessionServiceProvider());
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

RoutingManager::declareRouting($app);

return $app;
