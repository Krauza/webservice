<?php

namespace Krauza\Entity;

class Card
{
    private $obverse;
    private $reverse;

    public function __construct(string $obverse, string $reverse)
    {
        $this->obverse = $obverse;
        $this->reverse = $reverse;
    }

    public function getReverse(): string
    {
        return $this->reverse;
    }

    public function getObverse(): string
    {
        return $this->obverse;
    }
}
