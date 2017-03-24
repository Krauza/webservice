<?php

use Krauza\Entity\Card;
use Krauza\Factory\CardFactory;

class CardFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function cardFactoryShouldReturnCardObject()
    {
        $data = [
            'reverse' => 'word',
            'obverse' => 'magic word'
        ];

        $card = CardFactory::createCard($data);
        $this->assertInstanceOf(Card::class, $card);
    }
}
