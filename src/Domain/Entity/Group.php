<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Aggregate\Fiches;
use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class Group extends Entity
{
    private $id;
    private $owner;
    private $name;
    private $fiches;

    const NAME_MAX_LENGTH = 120;

    public function __construct($id = null, User $owner, \string $name, Fiches $fiches = null)
    {
        $this->setId($id);
        $this->setName($name);
        $this->owner = $owner;
        $this->fiches = $fiches;
    }

    public static function getFieldsNames(): array
    {
        return [
            'id' => 'int',
            'owner_id' => User::class,
            'name' => 'string',
            'fiches' => Fiches::class
        ];
    }

    public function getValues(): array
    {
        return [
            'id' => $this->getId(),
            'owner_id' => $this->getOwnerId(),
            'name' => $this->getName()
        ];
    }

    public function setId( $id = null)
    {
        $this->id = $id;
    }

    public function setName(\string $name)
    {
        $name = trim($name);

        if (empty($name)) {
            throw new FieldIsRequired('name');
        }

        if (strlen($name) > self::NAME_MAX_LENGTH) {
            throw new ValueIsTooLong('name');
        }

        $this->name = $name;
    }

    public function setFiches(Fiches $fiches)
    {
        $this->fiches = $fiches;
    }

    public function addFiche(Fiche $fiche)
    {
        if ($this->fiches instanceof Fiches) {
            $this->fiches->append($fiche);
        } else {
            throw new \Exception;
        }
    }

    public function getName(): \string
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFiches(): Fiches
    {
        return $this->fiches;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getOwnerId()
    {
        return $this->owner->getId();
    }
}
