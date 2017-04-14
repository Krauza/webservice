<?php

namespace Krauza\Core\Factory;

use Krauza\Core\Entity\User;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\Policy\PasswordPolicy;
use Krauza\Core\ValueObject\UserEmail;
use Krauza\Core\ValueObject\UserName;

class UserFactory
{
    public static function createUser(array $data, PasswordPolicy $passwordPolicy, IdPolicy $idPolicy): User
    {
        $userName = new UserName($data['name']);
        $userEmail = new UserEmail($data['email']);

        $user = new User($userName);
        $user->setEmail($userEmail);
        $user->setPassword($passwordPolicy->getPassword());
        $user->setId($idPolicy->generate());

        return $user;
    }
}
