<?php

namespace Krauza\Infrastructure\DataAccess;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\BoxSectionsRepository as IBoxSectionsRepository;

final class BoxSectionsRepository implements IBoxSectionsRepository
{
    private const TABLE_NAME = 'box_card';

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $engine;

    public function __construct($engine)
    {
        $this->engine = $engine;
    }

    public function addCardToInbox(Box $box, Card $card): void
    {
        $this->engine->insert(self::TABLE_NAME, [
            'box_id' => $box->getId(),
            'card_id' => $card->getId()
        ]);
    }

    public function getFirstCardFromBoxAtCurrentSection(Box $box): ?card
    {
        // TODO: Implement getFirstCardFromBoxAtCurrentSection() method.
    }

    public function getNumberOfCardsInSection(Box $box, int $section): int
    {
        // TODO: Implement getNumberOfCardsInSection() method.
    }

    public function moveCardsFromInboxToFirstSection(Box $box, int $numberOfCards): void
    {
        // TODO: Implement moveCardsFromInboxToFirstSection() method.
    }

    public function getNotEmptySection(): ?int
    {
        // TODO: Implement getNotEmptySection() method.
    }

    public function getBoxSectionByCard(Box $box, Card $card): int
    {
        // TODO: Implement getBoxSectionByCard() method.
    }

    public function moveCardBetweenBoxSections(Box $box, Card $card, int $fromSection, int $toSection): void
    {
        // TODO: Implement moveCardBetweenBoxSections() method.
    }

    public function setCardAsArchived(Box $box, Card $card): void
    {
        // TODO: Implement setCardAsArchived() method.
    }
}
