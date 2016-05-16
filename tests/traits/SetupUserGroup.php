<?php

require_once('SetupGroup.php');

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Repository\UserFichesRepository;

/**
 * Trait SetupUserGroup
 *
 * @property $user
 */
trait SetupUserGroup
{
	use SetupGroup;

	private $userGroup;
	private $userFichesRepository;

	private function setupUserGroup()
	{
		$userFichesRepositoryMock = $this->getMock(UserFichesRepository::class);

		$this->setupGroup();
		$this->userFichesRepository = new $userFichesRepositoryMock();
		$this->userGroup = new UserGroup($this->user, $this->group, $this->userFichesRepository);
	}
}
