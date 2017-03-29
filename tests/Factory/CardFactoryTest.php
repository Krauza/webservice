<?php

use Krauza\Entity\Card;
use Krauza\Factory\CardFactory;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;

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

        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));

        $card = CardFactory::createCard($data, $idMock);
        $this->assertInstanceOf(Card::class, $card);
    }
}
