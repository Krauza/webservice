<?php

use Krauza\Core\Entity\Card;
use Krauza\Core\Factory\CardFactory;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;

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
