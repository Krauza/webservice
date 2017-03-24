<?php

namespace Krauza\Repository;

use Krauza\Entity\Card;

interface CardRepository
{
    public function __construct($engine);
    public function add(Card $card);
}
