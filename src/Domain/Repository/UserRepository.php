<?php

namespace Fiche\Domain\Repository;

use Fiche\Domain\Entity\User;

interface UserRepository
{
	public function insert(User $user);
	public function getById($id): User;
	public function getByEmail($email): User;
}
