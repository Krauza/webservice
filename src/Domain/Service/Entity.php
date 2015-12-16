<?php

namespace Fiche\Domain\Service;

abstract class Entity
{
	abstract public static function getFieldsNames(): array;
	abstract public function getValues(): array;
}
