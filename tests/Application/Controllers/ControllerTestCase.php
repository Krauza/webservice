<?php

declare(strict_types=1);

use Silex\WebTestCase;
use Dotenv\Dotenv;

abstract class ControllerTestCase extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $env = new Dotenv(__DIR__ . '/../../');
        $env->load();
        shell_exec('php ' . __DIR__ . '/../../../run/install_mysql.php');

        $app = require __DIR__.'/../../../public/app.php';
        $app['session.test'] = true;
        $app['session.storage.handler'] = null;

        return $app;
    }
}
