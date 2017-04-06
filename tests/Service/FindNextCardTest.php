<?php

use Krauza\UseCase\FindNextCard;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Card;
use Krauza\Entity\Box;

class FindNextFicheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetNextCard()
    {
        $boxRepositoryMock = $this->getMock(BoxRepository::class);
        $cardRepositoryMock = $this->getMock(CardRepository::class);
        $boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();

        $findNextCard = new FindNextCard($boxRepositoryMock, $cardRepositoryMock);
        $card = $findNextCard->find($boxMock);
        $this->assertInstanceOf(Card::class, $card);
    }
}
