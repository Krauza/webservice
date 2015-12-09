<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Aggregate\Fiches;
use Fiche\Domain\Service\UniqueIdInterface;

class Group
{
    private $id;
    private $name;
    private $fiches;

    public function __construct(UniqueIdInterface $id, string $name, Fiches $fiches)
    {
        $this->id = $id;
        $this->name = $name;
        $this->fiches = $fiches;
    }
}
