<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\FichesCollection;

interface FichesRepository
{
	public function getForGroup(Group $group, FichesCollection $fichesCollection);
	public function insert(Fiche $fiche);
}
