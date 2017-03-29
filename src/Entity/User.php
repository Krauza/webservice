<?php

namespace Krauza\Entity;

use Krauza\ValueObject\EntityId;
use Krauza\ValueObject\UserName;
use Krauza\ValueObject\UserEmail;

class User implements Entity
{
    private $id;
    private $name;
    private $password;
    private $email;

    public function __construct(UserName $userName)
    {
        $this->name = $userName;
    }

    public function setId(EntityId $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setEmail(UserEmail $email)
    {
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
