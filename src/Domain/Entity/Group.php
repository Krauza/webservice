<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\Service\FichesCollection;
use Fiche\Domain\ValueObject\GroupName;

class Group extends Entity
{
    private $id;
    private $owner;
    private $name;
    private $fiches;

    public function __construct(UniqueIdInterface $id = null, User $owner, GroupName $name, FichesCollection $fiches = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
        $this->fiches = $fiches;
    }

    public function setFiches(FichesCollection $fiches)
    {
        $this->fiches = $fiches;
    }

    public function addFiche(Fiche $fiche)
    {
        if ($this->fiches instanceof FichesCollection) {
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

    public function getFiches(): FichesCollection
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
