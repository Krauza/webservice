<?php

use Krauza\Entity\Card;

class CardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ficheShouldBeCreatable()
    {
        $card = new Card('first', 'second');
        $this->assertEquals('first', $card->getObverse());
        $this->assertEquals('second', $card->getReverse());
    }
}
