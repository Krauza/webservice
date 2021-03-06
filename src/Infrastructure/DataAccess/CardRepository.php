<?php

namespace Krauza\Infrastructure\DataAccess;

use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\CardRepository as ICardRepository;
use Krauza\Core\ValueObject\EntityId;
use Krauza\Core\ValueObject\CardWord;

final class CardRepository implements ICardRepository
{
    private const TABLE_NAME = 'card';

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $engine;

    public function __construct($engine)
    {
        $this->engine = $engine;
    }

    public function add(Card $card)
    {
        $this->engine->insert(self::TABLE_NAME, [
            'id' => $card->getId(),
            'obverse' => $card->getObverse(),
            'reverse' => $card->getReverse()
        ]);
    }

    public function get(string $id): Card
    {
        $stmt = $this->engine->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE id = :id");
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetch();

        $obverse = new CardWord($result['obverse']);
        $reverse = new CardWord($result['reverse']);
        $card = new Card($obverse, $reverse);
        $card->setId(new EntityId($result['id']));

        return $card;
    }
}
