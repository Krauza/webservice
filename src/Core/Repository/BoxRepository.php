<?php

namespace Krauza\Core\Repository;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Entity\User;

interface BoxRepository
{
    public function __construct($engine);
    public function add(Box $box, User $user);
    public function addCardToInbox(Box $box, Card $card);
    public function updateBoxSection(Box $box);
    public function getFirstCardFromBoxAtSection(Box $box);
    public function getNumberOfCardsInSection(int $section);
    public function moveCardsFromInboxToFirstSection(int $numberOfCards);
    public function getNotEmptySection();
    public function getBoxSectionByCard(Box $box, Card $card): int;
    public function moveCardBetweenBoxSections(int $fromSection, int $toSection, Box $box, Card $card);
    public function setCardAsArchived(Box $box, Card $card);
}
