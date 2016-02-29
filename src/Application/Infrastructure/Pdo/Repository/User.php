<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Domain\Factory\UserFactory;
use Fiche\Domain\Repository\UserRepository;
use Fiche\Domain\Entity\User as UserEntity;

class User implements UserRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function getById($id): UserEntity
	{
		// TODO: Implement getById() method.
	}

	public function getByEmail($email): UserEntity
	{
//		$this->storage->
//		return UserFactory::create();
	}
}