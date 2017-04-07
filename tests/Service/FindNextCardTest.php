<?php

use Krauza\UseCase\FindNextCard;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Card;
use Krauza\Entity\Box;

class FindNextFicheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $cardRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxMock;

    public function setUp()
    {
        $this->boxRepositoryMock = $this->getMock(BoxRepository::class);
        $this->cardRepositoryMock = $this->getMock(CardRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldGetNextCard()
    {
        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $card = $findNextCard->find($this->boxMock);
        $this->assertInstanceOf(Card::class, $card);
    }

    /**
     * @test
     */
    public function shouldGetNextCardFromFirstSection()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $card = $findNextCard->find($this->boxMock);

        $this->boxRepositoryMock->expects($this->once())->method('getCardIdFromBoxAtSection')->with($this->boxMock, 1);
        $this->boxRepositoryMock->expects($this->once())->method('getNumberOfCardsInSection')->with(2)->willReturn(10);
        $this->assertInstanceOf(Card::class, $card);
    }

    /**
     * @test
     */
    public function shouldGetNextCardFromSecondSectionWhenLimitWasExceeded()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $card = $findNextCard->find($this->boxMock);

        $this->boxRepositoryMock->expects($this->once())->method('getCardIdFromBoxAtSection')->with($this->boxMock, 2);
        $this->boxRepositoryMock->expects($this->once())->method('getNumberOfCardsInSection')->with(2)->willReturn(100);
        $this->assertInstanceOf(Card::class, $card);
    }
}
