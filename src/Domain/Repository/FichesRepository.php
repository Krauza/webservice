<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;

interface FichesRepository
{
	public function getForGroup(Group $group);
	public function insert(Fiche $fiche);
}
