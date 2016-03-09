<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Repository\UserFichesRepository;
use Fiche\Domain\Service\UserFichesCollection;


class UserFiches implements PdoRepository, UserFichesRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function fetchAllForUserGroup(UserGroup $userGroupsCollection, UserFichesCollection $userFichesCollection) {
		// TODO: Implement fetchAllForUserGroup() method.
	}
}
