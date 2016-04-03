<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Service\UserFichesCollection;

interface UserFichesRepository
{
	public function fetchAllActiveForUserGroup(UserGroup $userGroups, UserFichesCollection $userFichesCollection);
	public function createConnections(UserGroup $userGroups, UserFichesCollection $userFichesCollection);
	public function getNewFichesToFirstGroup(UserGroup $userGroup);
}
