<?php

use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Entity\Box;
use Krauza\Core\UseCase\SetCurrentSection;

class SetCurrentSectionTest extends PHPUnit_Framework_TestCase
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

    /**
     * @test
     */
    public function shouldSkipToNextSectionWhenLimitWasExceeded()
    {
        $section = 1;
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(2)
            ))
            ->willReturnOnConsecutiveCalls(Box::getSectionLimit($section + 1));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldRewindToFirstSectionWhenCountOfCardsInSectionIsBelowLimit()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(2);
        $this->boxRepositoryMock->expects($this->exactly(3))
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(3),
                $this->equalTo(2)
            ))
            ->willReturnOnConsecutiveCalls(20, Box::getSectionLimit(2) - (Box::REWIND_LIMIT + 1), 1);

        $this->boxMock->expects($this->once())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldNotSkipToNextSectionWhenCurrentSectionIsLast()
    {
        $section = 4;
        $this->boxMock->method('getCurrentSection')->willReturn($section);
        $this->boxRepositoryMock->expects($this->exactly(2))
            ->method('getNumberOfCardsInSection')->with($section)
            ->willReturnOnConsecutiveCalls(Box::getSectionLimit($section));

        $this->boxMock->expects($this->never())->method('incrementCurrentSection');
        $this->boxMock->expects($this->never())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->never())->method('updateBoxSection');

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);;
    }

    /**
     * @test
     */
    public function shouldSkipToLastSection()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(3);
        $this->boxRepositoryMock->expects($this->exactly(2))
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(3),
                $this->equalTo(4)
            ))
            ->willReturn(Box::getSectionLimit(4));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldSkipToNotEmptySectionWhenCurrentSectionIsEmpty()
    {
        $this->boxRepositoryMock->expects($this->any())
            ->method('getFirstCardFromBoxAtCurrentSection')
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

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }
}
