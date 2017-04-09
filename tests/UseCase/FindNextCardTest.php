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
    public function shouldGetNextCardFromFirstSection()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $this->boxRepositoryMock->expects($this->once())->method('getCardIdFromBoxAtSection')->with($this->boxMock, 1);
        $this->boxRepositoryMock->expects($this->once())->method('getNumberOfCardsInSection')->with(2)->willReturn(10);
        $this->boxMock->expects($this->never())->method('incrementCurrentSection');

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldGetNextCardFromSecondSectionWhenLimitWasExceeded()
    {
        $this->boxMock->method('getCurrentSection')->willReturnOnConsecutiveCalls(1, 2, 2, 3, 4);

        $this->boxRepositoryMock->expects($this->exactly(5))
            ->method('getCardIdFromBoxAtSection')->with($this->logicalOr(
                $this->equalTo($this->boxMock, 2),
                $this->equalTo($this->boxMock, 2),
                $this->equalTo($this->boxMock, 3),
                $this->equalTo($this->boxMock, 4),
                $this->equalTo($this->boxMock, 5)
            ));

        $this->boxRepositoryMock->expects($this->exactly(5))
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(2),
                $this->equalTo(2),
                $this->equalTo(3),
                $this->equalTo(4),
                $this->equalTo(5)
            ))
            ->willReturnOnConsecutiveCalls(100, 150, 200, 300, 400);

        $this->boxMock->expects($this->exactly(4))->method('incrementCurrentSection');

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
        $findNextCard->find($this->boxMock);
        $findNextCard->find($this->boxMock);
        $findNextCard->find($this->boxMock);
        $findNextCard->find($this->boxMock);
    }
}
