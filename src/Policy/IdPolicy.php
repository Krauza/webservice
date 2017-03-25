<?php

namespace Krauza\Policy;

interface IdPolicy
{
    public function __construct(string $id);
    public function __toString(): string;
}
