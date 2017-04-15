<?php

use Krauza\Core\UseCase\FindNextCard;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\CardRepository;
use Krauza\Core\Entity\Box;

class FindNextCardTest extends PHPUnit_Framework_TestCase
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
    public function shouldGetNextCardFromCurrentSection()
    {
        $section = 1;
        $this->mockGetCard();
        $this->boxMock->method('getCurrentSection')->willReturn($section);
        $this->boxRepositoryMock->expects($this->exactly(2))->method('getNumberOfCardsInSection')->with($this->logicalOr(
            $this->equalTo($section + 1),
            $this->equalTo($section)
        ))->willReturnOnConsecutiveCalls(10, 101);
        $this->boxMock->expects($this->never())->method('incrementCurrentSection');
        $this->boxMock->expects($this->never())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->never())->method('updateBoxSection');

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenBoxHasNoCards()
    {
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')
            ->with($this->boxMock)
            ->willReturn(null);

        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(0)
            ))
            ->willReturn(4);

        $this->boxRepositoryMock->expects($this->once())->method('getNotEmptySection')->willReturn(null);

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $this->assertNull($findNextCard->find($this->boxMock));
    }

    /**
     * @test
     */
    public function shouldSkipToNotEmptySectionWhenCurrentSectionIsEmpty()
    {
        $this->boxRepositoryMock->expects($this->any())
            ->method('getFirstCardFromBoxAtSection')
            ->with($this->boxMock)
            ->willReturnOnConsecutiveCalls(null, '1');

        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(0)
            ))
            ->willReturn(0);

        $this->boxMock->expects($this->once())->method('setCurrentSection')->with(3);
        $this->boxRepositoryMock->expects($this->exactly(2))
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $this->boxRepositoryMock->expects($this->once())->method('getNotEmptySection')->willReturn(3);
        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }
}
