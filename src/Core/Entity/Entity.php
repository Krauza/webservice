<?php

namespace Krauza\Core\Entity;

use Krauza\Core\ValueObject\EntityId;

interface Entity
{
    public function setId(EntityId $id);
    public function getId(): string;
}
