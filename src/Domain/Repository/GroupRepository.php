<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Policy\UniqueIdInterface;

interface GroupRepository
{
	public function getById($id): Group;
	public function insert(Group $group);
	public function update(Group $group);
}
