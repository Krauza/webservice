<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\ValueObject\Email;

class User extends Entity
{
    const NAME_MAX_LENGTH = 120;

    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct(\int $id = null, \string $name, Email $email, \string $password)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(\int $id = null)
    {
        $this->id = $id;
    }

    public function getName(): \string
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword(): \string
    {
        return $this->password;
    }

    public function setName(\string $name)
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

    public function getGroups()
    {

    }

    public static function getFieldsNames(): array
    {
        return [
            'id' => 'int',
            'name' => 'string',
            'email' => 'string',
            'password' => 'string'
        ];
    }

    public function getValues(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword()
        ];
    }
}
