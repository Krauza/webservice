<?php

namespace Krauza\Infrastructure\DataAccess;

use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\CardRepository as ICardRepository;

final class CardRepository implements ICardRepository
{

    public function __construct($engine)
    {
        parent::__construct($engine);
    }

    public function add(Card $card)
    {
        // TODO: Implement add() method.
    }

    public function get(string $id): Card
    {
        // TODO: Implement get() method.
    }
}
