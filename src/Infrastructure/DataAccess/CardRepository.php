<?php

namespace Krauza\Infrastructure\DataAccess;

use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\CardRepository as ICardRepository;

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
        // TODO: Implement get() method.
    }
}
