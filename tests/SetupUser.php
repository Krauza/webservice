<?php

use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\Email;
use Fiche\Domain\ValueObject\UserName;

trait SetupUser
{
	private $userId;
	private $userName;
	private $email;
	private $password;
	private $user;
	private $userGroupsRepository;

	private function setupUser()
	{
		$this->userId = new UniqueId();
		$this->userName = new UserName('name');
		$this->email = new Email('test@test.test');
		$this->password = 'D3F$##$F3VWCA#CVFH^&^4&M9';
		$mockUserGroupsRepository = $this->getMock(Fiche\Domain\Repository\UserGroupsRepository::class);
		$this->userGroupsRepository = new $mockUserGroupsRepository();

		$this->user = new User($this->userId, $this->userName, $this->email, $this->password, $this->userGroupsRepository);
	}
}
