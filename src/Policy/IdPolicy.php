<?php

namespace Krauza\Policy;

use Krauza\ValueObject\EntityId;

interface IdPolicy
{
    public function generate(): EntityId;
}
