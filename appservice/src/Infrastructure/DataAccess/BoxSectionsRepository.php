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
            'card_id' => $card->getId(),
            'section' => Box::INBOX
        ]);
    }

    public function getFirstCardFromBoxAtCurrentSection(Box $box): ?card
    {
        $sql = 'SELECT card_id FROM :tableName WHERE box_id = :box_id AND card_section = :current_section ORDER BY modified_date LIMIT 1';
        $result = $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':card_section' => $box->getCurrentSection()
        ]);

        if (empty($result)) {
            return null;
        }

        $cardRepository = new CardRepository($this->engine);
        return $cardRepository->get($result);
    }

    public function getNumberOfCardsInSection(Box $box, int $section): int
    {
        $sql = 'SELECT COUNT(*) FROM :tableName WHERE box_id = :box_id AND card_section = :current_section';
        return $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':current_section' => $box->getCurrentSection()
        ]);
    }

    public function moveCardsFromInboxToFirstSection(Box $box): void
    {
        $sql = 'UPDATE :tableName SET card_section = :card_section WHERE card_section = :inbox LIMIT :limit';
        $this->engine->executeUpdate($sql, [
            ':tableName' => self::TABLE_NAME,
            ':card_section' => Box::FIRST_SECTION,
            ':inbox' => Box::INBOX,
            ':limit' => Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX
        ]);
    }

    public function getNotEmptySection(Box $box): ?int
    {
        $sql = 'SELECT card_section FROM :tableName WHERE box_id = :box_id AND card_section BETWEEN :firstSection AND :lastSection LIMIT 1';
        return $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':firstSection' => Box::FIRST_SECTION,
            ':lastSection' => Box::LAST_SECTION
        ]);
    }

    public function getBoxSectionByCard(Box $box, Card $card): int
    {
        $sql = 'SELECT card_section FROM :tableName WHERE card_id = :card_id AND box_id = :box_id';
        return $this->engine->fetchAssoc($sql, [
            ':tableName' => self::TABLE_NAME,
            ':box_id' => $box->getId(),
            ':card_id' => $box->gedtId()
        ]);
    }

    public function moveCardBetweenBoxSections(Box $box, Card $card, int $fromSection, int $toSection): void
    {
        $this->setSection($box->getId(), $card->getId(), $toSection);
    }

    public function setCardAsArchived(Box $box, Card $card): void
    {
        $this->setSection($box->getId(), $card->getId(), Box::ARCHIVED);
    }

    private function setSection(string $boxId, string $cardId, $section)
    {
        $this->engine->update(self::TABLE_NAME, ['card_section' => $section], ['box_id' => $boxId, 'card_id' => $cardId]);
    }
}
