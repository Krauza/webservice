<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\Service\UserGroupsCollection;

interface UserGroupsRepository
{
	public function insert(Group $group, User $user): UserGroup;
	public function getByGroupForUser(Group $group, User $user): UserGroup;
	public function fetchAllForUser(User $user, UserGroupsCollection $userGroupsCollection);
}
