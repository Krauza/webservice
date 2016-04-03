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

	public function fetchAllActiveForUserGroup(UserGroup $userGroupsCollection, UserFichesCollection $userFichesCollection) {
		$result = $this->storage->query(function($pdo, $operations) {

		});
	}

	public function createConnections(UserGroup $userGroups, UserFichesCollection $userFichesCollection) {
		$result = $this->storage->query(function($pdo, $operations) {

		});
	}

	public function getNewFichesToFirstGroup(UserGroup $userGroup)
	{
		// TODO: Implement getNewFichesToFirstGroup() method.
	}
}
