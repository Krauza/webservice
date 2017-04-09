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
    public function shouldGetNextCardFromCurrentSection()
    {
        $section = 1;
        $this->boxMock->method('getCurrentSection')->willReturn($section);
        $this->boxRepositoryMock->expects($this->once())->method('getFirstCardFromBoxAtSection')->with($this->boxMock);
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
    public function shouldGetNextCardFromNextSectionWhenLimitWasExceeded()
    {
        $section = 1;
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')->with($this->equalTo($this->boxMock));

        $this->boxRepositoryMock->expects($this->once())
            ->method('getNumberOfCardsInSection')->with($section + 1)
            ->willReturnOnConsecutiveCalls(FindNextCard::getSectionLimit($section + 1));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldNotSkipToNextSectionWhenCurrentSectionIsLastAndGetCard()
    {
        $section = 4;
        $this->boxMock->method('getCurrentSection')->willReturn($section);
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')->with($this->equalTo($this->boxMock));

        $this->boxRepositoryMock->expects($this->once())
            ->method('getNumberOfCardsInSection')->with($section)
            ->willReturnOnConsecutiveCalls(FindNextCard::getSectionLimit($section));

        $this->boxMock->expects($this->never())->method('incrementCurrentSection');
        $this->boxMock->expects($this->never())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->never())->method('updateBoxSection');

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldSkipToLastSectionAndGetCard()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(3);
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')->with($this->equalTo($this->boxMock));

        $this->boxRepositoryMock->expects($this->once())
            ->method('getNumberOfCardsInSection')->with(4)
            ->willReturnOnConsecutiveCalls(FindNextCard::getSectionLimit(4));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldRewindToFirstSectionWhenCountOfCardsInSectionIsNormal()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(2);
        $this->boxRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtSection')->with($this->equalTo($this->boxMock));

        $this->boxRepositoryMock->expects($this->exactly(2))
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(3),
                $this->equalTo(2)
            ))
            ->willReturnOnConsecutiveCalls(20, FindNextCard::getSectionLimit(2) - (FindNextCard::REWIND_LIMIT + 1));

        $this->boxMock->expects($this->once())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $findNextCard = new FindNextCard($this->boxRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }
}
