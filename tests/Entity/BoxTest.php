<?php

use Krauza\Entity\Box;

class BoxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function boxShouldReturnNextFiche()
    {
        $boxRepositoryMock = $this->getMock(Krauza\Repository\BoxRepository::class);
        $userMock = $this->getMockBuilder(\Krauza\Entity\User::class)->disableOriginalConstructor()->getMock();
        $box = new Box($boxRepositoryMock, $userMock);
        $this->assertInstanceOf(\Krauza\Entity\Card::class, $box->getNextCard());
    }
}
