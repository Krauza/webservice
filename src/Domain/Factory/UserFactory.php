<?php

namespace Fiche\Domain\Factory;

use Fiche\Domain\Entity\User;
use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\Repository\UserGroupsRepository;
use Fiche\Domain\ValueObject\Email;
use Fiche\Domain\ValueObject\UserName;

class UserFactory
{
	public static function create(UniqueIdInterface $id = null, string $name, string $email, string $password, UserGroupsRepository $userGroupsRepository): User
	{
		$name = new UserName($name);
		$email = new Email($email);

		return new User($id, $name, $email, $password, $userGroupsRepository);
	}
}
