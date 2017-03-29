<?php

use Krauza\Entity\Card;
use Krauza\ValueObject\CardWord;
use Krauza\ValueObject\EntityId;

class CardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ficheShouldBeCreatable()
    {
        $card = new Card(new CardWord('first'), new CardWord('second'));
        $card->setId(new EntityId('1'));

        $this->assertEquals('first', $card->getObverse());
        $this->assertEquals('second', $card->getReverse());
        $this->assertEquals('1', $card->getId());
    }
}
