<?php

namespace Krauza\Core\Policy;

use Krauza\Core\ValueObject\EntityId;

interface IdPolicy
{
    public function generate(): EntityId;
}
