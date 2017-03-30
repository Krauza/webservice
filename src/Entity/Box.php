<?php

namespace Krauza\Entity;

use Krauza\ValueObject\BoxName;
use Krauza\ValueObject\EntityId;

class Box implements Entity
{
    private $id;
    private $name;

    public function __construct(BoxName $boxName)
    {
        $this->name = $boxName;
    }

    public function setId(EntityId $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
