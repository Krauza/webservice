<?php

namespace Krauza\Core\Repository;

use Krauza\Core\Entity\Card;

interface CardRepository
{
    public function __construct($engine);
    public function add(Card $card);
    public function get(string $id): Card;
}
