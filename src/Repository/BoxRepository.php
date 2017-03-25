<?php

namespace Krauza\Repository;

use Krauza\Entity\Box;
use Krauza\Entity\Card;

interface BoxRepository
{
    public function __construct($engine);
    public function addCardToInbox(Box $box, Card $card);
}