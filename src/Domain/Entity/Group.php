<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Aggregate\Fiches;
use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\UniqueIdInterface;

class Group extends Entity
{
    private $id;
    private $name;
    private $fiches;

    public function __construct(UniqueIdInterface $id, string $name, Fiches $fiches = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->fiches = $fiches;
    }

    public static function getFieldsNames(): array
    {
        return [
            UniqueIdInterface::class => 'id',
            'string' => 'name',
            Fiches::class => 'fiches'
        ];
    }
}
