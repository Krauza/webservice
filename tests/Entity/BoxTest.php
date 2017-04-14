<?php

use Krauza\Core\Entity\Box;
use Krauza\Core\ValueObject\BoxName;
use Krauza\Core\ValueObject\EntityId;

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
