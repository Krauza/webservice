<?php

namespace Krauza\Entity;

use Krauza\ValueObject\UserName;
use Krauza\ValueObject\UserEmail;
use Krauza\Policy\PasswordPolicy;

class User
{
    private $name;
    private $password;
    private $email;

    public function __construct(UserName $userName, PasswordPolicy $password, UserEmail $email)
    {
        $this->name = $userName;
        $this->password = $password;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
