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
        $sql = 'SELECT card_id FROM :tableName WHERE box_id = :box_id AND card_section = :current_section ORDER BY modified_date';
        $result = $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':current_section' => $box->getCurrentSection()
        ]);

        if (empty($result)) {
            return null;
        }

        $cardRepository = new CardRepository($this->engine);
        return $cardRepository->get($result);
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
        $sql = 'SELECT card_section FROM :tableName WHERE card_id = :card_id AND box_id = :box_id';
        return $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':card_id' => $box->getId()
        ]);
    }

    public function moveCardBetweenBoxSections(Box $box, Card $card, int $fromSection, int $toSection): void
    {
        $this->engine->update(self::TABLE_NAME, ['card_section' => $toSection], ['box_id' => $box->getId(), 'card_id' => $card->getId()]);
    }

    public function setCardAsArchived(Box $box, Card $card): void
    {
        // TODO: Implement setCardAsArchived() method.
    }
}
