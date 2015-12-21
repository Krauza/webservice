<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Service\StorageInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
	protected $app;
	protected $storage;
	protected $request;

	final public function __construct(Application $app, Request $request) {
		$this->app = $app;
		$this->storage = $app['storage'];
		$this->request = $request;
	}
}
