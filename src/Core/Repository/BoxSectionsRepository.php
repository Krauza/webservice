<?php

namespace Krauza\Core\Repository;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;

interface BoxSectionsRepository
{
    public function __construct($engine);
    public function addCardToInbox(Box $box, Card $card);
    public function getFirstCardFromBoxAtCurrentSection(Box $box);
    public function getNumberOfCardsInSection(Box $box, int $section);
    public function moveCardsFromInboxToFirstSection(Box $box, int $numberOfCards);
    public function getNotEmptySection(): ?int;
    public function getBoxSectionByCard(Box $box, Card $card);
    public function moveCardBetweenBoxSections(Box $box, Card $card, int $fromSection, int $toSection);
    public function setCardAsArchived(Box $box, Card $card);
}
