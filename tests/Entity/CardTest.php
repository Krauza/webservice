<?php

use Krauza\Entity\Card;
use Krauza\ValueObject\CardWord;

class CardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ficheShouldBeCreatable()
    {
        $card = new Card(new CardWord('first'), new CardWord('second'));
        $this->assertEquals('first', $card->getObverse());
        $this->assertEquals('second', $card->getReverse());
    }
}
