<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Aggregate\Fiches;
use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class Group extends Entity
{
    private $id;
    private $name;
    private $fiches;

    const NAME_MAX_LENGTH = 120;

    public function __construct(\int $id = null, \string $name, Fiches $fiches = null)
    {
        $this->setId($id);
        $this->setName($name);
        $this->fiches = $fiches;
    }

    public static function getFieldsNames(): array
    {
        return [
            'int' => 'id',
            'string' => 'name',
            Fiches::class => 'fiches'
        ];
    }

    public function getValues(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    public function setId(\int $id = null)
    {
        $this->id = $id;
    }

    public function setName(\string $name)
    {
        $name = trim($name);

        if(empty($name)) {
            throw new FieldIsRequired('name');
        }

        if(strlen($name) > self::NAME_MAX_LENGTH) {
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
        if($this->fiches instanceof Fiches) {
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
}
