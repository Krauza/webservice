<?php

use Krauza\Entity\Card;
use Krauza\ValueObject\CardWord;
use Krauza\Policy\IdPolicy;

class CardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ficheShouldBeCreatable()
    {
        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('__toString')->willReturn('1');

        $card = new Card(new CardWord('first'), new CardWord('second'));
        $card->setId($idMock);

        $this->assertEquals('first', $card->getObverse());
        $this->assertEquals('second', $card->getReverse());
        $this->assertEquals('1', $card->getId());
    }
}
