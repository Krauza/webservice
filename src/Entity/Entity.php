<?php

namespace Krauza\Entity;

use Krauza\Policy\IdPolicy;

interface Entity
{
    public function setId(IdPolicy $id);
    public function getId(): string;
}
