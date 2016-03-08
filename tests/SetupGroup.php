<?php

require_once('SetupUser.php');

use Fiche\Domain\Entity\Group;
use Fiche\Domain\ValueObject\GroupName;
use Fiche\Application\Infrastructure\UniqueId;

trait SetupGroup
{
	use SetupUser;

	private $groupId;
	private $group;
	private $groupName;
	private $fichesRepository;

	private function setupGroup()
	{
		$this->groupId = new UniqueId();
		$this->groupName = new GroupName('group');
		$fichesRepository = $this->getMock(Fiche\Domain\Repository\FichesRepository::class);
		$this->fichesRepository = new $fichesRepository();
		$this->setupUser();

		$this->group = new Group($this->groupId, $this->user, $this->groupName, $this->fichesRepository);
	}
}
