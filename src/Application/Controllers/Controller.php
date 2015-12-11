<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Service\StorageInterface;

abstract class Controller
{
	protected $storage;

	final public function __construct(StorageInterface $storage) {
		$this->storage = $storage;
	}
}
