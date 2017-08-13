<?php

namespace Krauza\Core\Factory;

use Krauza\Core\Entity\Card;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\CardWord;

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
