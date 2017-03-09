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
        $this->assertEquals('string', $card->getObverse());
        $this->assertEquals('string', $card->getReverse());
    }
}
