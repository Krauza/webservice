<?php

namespace Krauza\Entity;

use Krauza\ValueObject\EntityId;

interface Entity
{
    public function setId(EntityId $id);
    public function getId(): string;
}
