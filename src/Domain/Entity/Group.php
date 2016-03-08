<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\Repository\FichesRepository;
use Fiche\Domain\Service\FichesCollection;
use Fiche\Domain\ValueObject\GroupName;

class Group extends Entity
{
    protected $id;
    private $owner;
    private $name;
    private $fiches;

    private $ficheRepository;

    public function __construct(UniqueIdInterface $id, User $owner, GroupName $name, FichesRepository $ficheRepository)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;

        $this->ficheRepository = $ficheRepository;
    }

    public function addFiche(Fiche $fiche)
    {
        if (!($this->fiches instanceof FichesCollection))
        {
            $this->fiches = new FichesCollection();
        }

        $this->fiches->append($fiche);
    }

    public function setName(GroupName $name)
    {
        $this->name = $name;
    }

    public function getName(): string
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

    public function isOwner(User $user)
    {
        return (string) $user->getId() === (string) $this->getOwner()->getId();
    }
}
