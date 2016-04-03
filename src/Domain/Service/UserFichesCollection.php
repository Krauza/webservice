<?php

namespace Fiche\Domain\Service;

use Fiche\Domain\Aggregate\UserFicheStatus;

class UserFichesCollection extends \ArrayObject
{
	public function getFichesCountAtLevel(int $level): int
	{

	}

	public function getFirstFromLevel(int $level): UserFicheStatus
	{
	}
}
