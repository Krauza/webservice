<?php

namespace Fiche\Domain\Entity;

abstract class Entity
{
	abstract public static function getFieldsNames(): array;
	abstract public function getValues(): array;
	abstract public function setId($id);
	abstract public function getId();
}
