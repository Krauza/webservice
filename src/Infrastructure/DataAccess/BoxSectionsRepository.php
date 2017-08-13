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
    private $dbal;

    public function __construct($engine)
    {
        $this->dbal = $engine;
    }

    public function addCardToInbox(Box $box, Card $card): void
    {
        $this->dbal->insert(self::TABLE_NAME, [
            'box_id' => $box->getId(),
            'card_id' => $card->getId(),
            'card_section' => Box::INBOX
        ]);
    }

    public function getFirstCardFromBoxAtCurrentSection(Box $box): string
    {
        $sql = 'SELECT card_id FROM box_card WHERE box_id = ? AND card_section = ? ORDER BY modified_date LIMIT 1';
        $result = $this->dbal->fetchAssoc($sql, [$box->getId(), $box->getCurrentSection()]);
        return $result['card_id'];
    }

    public function getNumberOfCardsInSection(Box $box, int $section): int
    {
        $sql = 'SELECT COUNT(*) FROM box_card WHERE box_id = ? AND card_section = ?';
        return count($this->dbal->fetchAssoc($sql, [$box->getId(), $section]));
    }

    public function moveCardsFromInboxToFirstSection(Box $box): void
    {
        $sql = 'UPDATE box_card SET card_section = :toSection WHERE box_id = :boxId AND card_section = :fromSection LIMIT :limit';
        $stmt = $this->dbal->prepare($sql);
        $stmt->bindValue(':boxId', $box->getId());
        $stmt->bindValue(':toSection', Box::FIRST_SECTION, \PDO::PARAM_INT);
        $stmt->bindValue(':fromSection', Box::INBOX, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getNotEmptySection(Box $box): ?int
    {
        $sql = 'SELECT card_section FROM box_card WHERE box_id = ? AND card_section BETWEEN ? AND ? LIMIT 1';
        return $this->dbal->fetchAssoc($sql, [$box->getId(), Box::FIRST_SECTION, Box::LAST_SECTION]);
    }

    public function getBoxSectionByCard(Box $box, Card $card): int
    {
        $sql = 'SELECT card_section FROM box_card WHERE card_id = ? AND box_id = ?';
        return $this->dbal->fetchAssoc($sql, [$box->getId(), $box->getId()]);
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
        $this->dbal->update(self::TABLE_NAME, ['card_section' => $section], ['box_id' => $boxId, 'card_id' => $cardId]);
    }
}
