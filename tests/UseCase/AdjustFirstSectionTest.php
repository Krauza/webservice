<?php

use Krauza\Core\UseCase\FindNextCard;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\CardRepository;
use Krauza\Core\Entity\Box;

class AdjustFirstSectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxMock;

    public function setUp()
    {
        $this->boxRepositoryMock = $this->getMock(BoxRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    public function mockGetCard()
    {
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')
            ->with($this->boxMock)
            ->willReturn('1');
    }

    /**
     * @test
     */
    public function shouldMoveMoreCardsFromInboxWhenFirstSectionIsEmpty()
    {
        $this->mockGetCard();
        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(0)
            ))
            ->willReturn(4);

        $this->boxRepositoryMock->expects($this->once())
            ->method('moveCardsFromInboxToFirstSection')->with(Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }
}
