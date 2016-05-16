<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\Repository\UserGroupsRepository;
use Fiche\Domain\Service\UserGroupsCollection;
use Fiche\Domain\ValueObject\Email;
use Fiche\Domain\ValueObject\UserName;

class User extends Entity
{
    private $name;
    private $email;
    private $password;
    private $userGroups;
    private $userGroupsRepository;

    public function __construct(UniqueIdInterface $id, UserName $name, Email $email, string $password, UserGroupsRepository $userGroupsRepository)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

        $this->userGroups = null;
        $this->userGroupsRepository = $userGroupsRepository;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setName(UserName $name)
    {
        $this->name = $name;
    }

    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getUserGroups(): UserGroupsCollection
    {
        if($this->userGroups === null) {
            $userGroups = new UserGroupsCollection();
            $this->userGroupsRepository->fetchAllForUser($this, $userGroups);

            $this->userGroups = $userGroups;
        }

        return $this->userGroups;
    }
}
