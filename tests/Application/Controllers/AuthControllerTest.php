<?php

declare(strict_types=1);

use Silex\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        return require __DIR__.'/../../../public/app.php';
    }
}
