<?php

namespace Krauza\Entity;

use Krauza\ValueObject\EntityId;

class Box implements Entity
{
    private $id;

    public function setId(EntityId $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
