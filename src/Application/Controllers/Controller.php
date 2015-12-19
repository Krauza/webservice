<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Service\StorageInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
	protected $storage;
	protected $request;

	final public function __construct(StorageInterface $storage, Request $request) {
		$this->storage = $storage;
		$this->request = $request;
	}
}
