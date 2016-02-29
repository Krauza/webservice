<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Entity\User;
use Fiche\Domain\Service\UserGroupsCollection;

interface UserGroupsRepository
{
	public function getForUser(User $user, UserGroupsCollection $userGroupsCollection);
}
