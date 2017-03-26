<?php

namespace Krauza\Entity;

use Krauza\ValueObject\CardWord;
use Krauza\Policy\IdPolicy;

class Card implements Entity
{
    private $id;
    private $obverse;
    private $reverse;

    public function __construct(CardWord $obverse, CardWord $reverse)
    {
        $this->obverse = $obverse;
        $this->reverse = $reverse;
    }

    public function setId(IdPolicy $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
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
