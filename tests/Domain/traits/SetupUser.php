<?php

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
		$mockUniqeId = $this->getMock(Fiche\Domain\Policy\UniqueIdInterface::class);
		$mockUserGroupsRepository = $this->getMock(Fiche\Domain\Repository\UserGroupsRepository::class);

		$this->userId = new $mockUniqeId();
		$this->userName = new UserName('name');
		$this->email = new Email('test@test.test');
		$this->password = 'D3F$##$F3VWCA#CVFH^&^4&M9';
		$this->userGroupsRepository = new $mockUserGroupsRepository();
		$this->user = new User($this->userId, $this->userName, $this->email, $this->password, $this->userGroupsRepository);
	}
}
