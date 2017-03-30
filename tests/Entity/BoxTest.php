<?php

use Krauza\Entity\Box;
use Krauza\ValueObject\BoxName;
use Krauza\ValueObject\EntityId;

class BoxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function boxShouldBeCreatable()
    {
        $card = new Box(new BoxName('name'));
        $card->setId(new EntityId('1'));

        $this->assertEquals('name', $card->getName());
        $this->assertEquals('1', $card->getId());
    }
}
