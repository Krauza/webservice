<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Service\UserFichesCollection;

interface UserFichesRepository
{
	public function fetchAllForUserGroup(UserGroup $userGroupsCollection, UserFichesCollection $userFichesCollection);
}
