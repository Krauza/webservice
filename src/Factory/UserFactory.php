<?php

namespace Krauza\Factory;

use Krauza\Entity\User;
use Krauza\Policy\IdPolicy;
use Krauza\Policy\PasswordPolicy;
use Krauza\ValueObject\UserEmail;
use Krauza\ValueObject\UserName;

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
