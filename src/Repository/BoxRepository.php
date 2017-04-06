<?php

namespace Krauza\Repository;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Entity\User;

interface BoxRepository
{
    public function __construct($engine);
    public function add(Box $box, User $user);
    public function addCardToInbox(Box $box, Card $card);
    public function getCardFromBoxAtSection(Box $box, int $section);
}
