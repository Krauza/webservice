<?php

namespace Krauza\Factory;

use Krauza\Entity\Card;
use Krauza\ValueObject\CardWord;

class CardFactory
{
    public static function createCard(array $data): Card
    {
        $obverse = new CardWord($data['obverse']);
        $reverse = new CardWord($data['reverse']);

        return new Card($obverse, $reverse);
    }
}
