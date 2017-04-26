<?php

namespace Krauza\Infrastructure\Policy;

use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;

class UniqueId implements IdPolicy
{
    public function generate(): EntityId
    {
        return uniqid();
    }
}
