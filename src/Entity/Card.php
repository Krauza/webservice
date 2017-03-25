<?php

namespace Krauza\Entity;

use Krauza\ValueObject\CardWord;

class Card extends BaseEntity
{
    private $obverse;
    private $reverse;

    public function __construct(CardWord $obverse, CardWord $reverse)
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
