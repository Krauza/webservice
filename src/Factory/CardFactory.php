<?php

namespace Krauza\Factory;

use Krauza\Entity\Card;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\CardWord;

class CardFactory
{
    public static function createCard(array $data, IdPolicy $idPolicy): Card
    {
        $obverse = new CardWord($data['obverse']);
        $reverse = new CardWord($data['reverse']);

        $card = new Card($obverse, $reverse);
        $card->setId($idPolicy->generate());

        return $card;
    }
}
