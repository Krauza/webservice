<?php

namespace Fiche\Domain\Entity;

abstract class Entity
{
	protected $id;

	abstract public function getId();
}
