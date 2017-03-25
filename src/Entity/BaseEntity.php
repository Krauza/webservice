<?php

namespace Krauza\Entity;

use Krauza\Policy\IdPolicy;

class BaseEntity
{
    private $id;

    public function setId(IdPolicy $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
