<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\Exceptions\ValueIsNotEmail;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class User extends Entity
{
    const NAME_MAX_LENGTH = 120;
    const EMAIL_MAX_LENGTH = 255;
    const EMAIL_PATTERN = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct(\int $id = null, \string $name, \string $email, \string $password)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId(): \int
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

    public function getEmail(): \string
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

    public function setEmail(\string $email)
    {
        if(strlen($email) > self::EMAIL_MAX_LENGTH) {
            throw new ValueIsTooLong('email');
        }

        if(!preg_match(self::EMAIL_PATTERN, $email)) {
            throw new ValueIsNotEmail('email');
        }

        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public static function getFieldsNames(): array
    {
        // TODO: Implement getFieldsNames() method.
    }

    public function getValues(): array
    {
        // TODO: Implement getValues() method.
    }
}
