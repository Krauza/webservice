<?php

declare(strict_types=1);

use Silex\WebTestCase;

abstract class ControllerTestCase extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../public/app.php';
        $app['session.test'] = true;
        $app['session.storage.handler'] = null;

        return $app;
    }
}
