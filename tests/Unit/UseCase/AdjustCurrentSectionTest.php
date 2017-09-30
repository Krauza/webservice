<?php

use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\BoxSectionsRepository;
use Krauza\Core\Entity\Box;
use Krauza\Core\UseCase\SetCurrentSection;

class SetCurrentSectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxSectionsRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxRepositoryMock;

    public function setUp()
    {
        $this->boxRepositoryMock = $this->getMock(BoxRepository::class);
        $this->boxSectionsRepositoryMock = $this->getMock(BoxSectionsRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldSkipToNextSectionWhenLimitWasExceeded()
    {
        $section = 1;
        $this->boxMock->method('getCurrentSection')->willReturn(1);
        $this->boxSectionsRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')
            ->willReturn(Box::getSectionLimit($section + 1));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock, $this->boxSectionsRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldRewindToFirstSectionWhenCountOfCardsInSectionIsBelowLimit()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(2);
        $this->boxSectionsRepositoryMock->expects($this->exactly(3))
            ->method('getNumberOfCardsInSection')
            ->willReturnOnConsecutiveCalls(20, Box::getSectionLimit(2) - (Box::REWIND_LIMIT + 1), 1);

        $this->boxMock->expects($this->once())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock, $this->boxSectionsRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldNotSkipToNextSectionWhenCurrentSectionIsLast()
    {
        $section = 4;
        $this->boxMock->method('getCurrentSection')->willReturn($section);
        $this->boxSectionsRepositoryMock->expects($this->exactly(2))
            ->method('getNumberOfCardsInSection')->with($this->boxMock, $section)
            ->willReturn(Box::getSectionLimit($section));

        $this->boxMock->expects($this->never())->method('incrementCurrentSection');
        $this->boxMock->expects($this->never())->method('rewindToFirstSection');
        $this->boxRepositoryMock->expects($this->never())->method('updateBoxSection');

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock, $this->boxSectionsRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);;
    }

    /**
     * @test
     */
    public function shouldSkipToLastSection()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(3);
        $this->boxSectionsRepositoryMock->expects($this->exactly(2))
            ->method('getNumberOfCardsInSection')
            ->willReturn(Box::getSectionLimit(4));

        $this->boxMock->expects($this->once())->method('incrementCurrentSection');
        $this->boxRepositoryMock->expects($this->once())
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock, $this->boxSectionsRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldSkipToNotEmptySectionWhenCurrentSectionIsEmpty()
    {
        $this->boxSectionsRepositoryMock->expects($this->any())
            ->method('getFirstCardFromBoxAtCurrentSection')
            ->with($this->boxMock)
            ->willReturnOnConsecutiveCalls(null, '1');

        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxSectionsRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')
            ->willReturn(0);

        $this->boxMock->expects($this->once())->method('setCurrentSection')->with(3);
        $this->boxRepositoryMock->expects($this->exactly(1))
            ->method('updateBoxSection')->with($this->equalTo($this->boxMock));

        $this->boxSectionsRepositoryMock->expects($this->once())->method('getNotEmptySection')->with($this->boxMock)->willReturn(3);

        $adjustCurrentSection = new SetCurrentSection($this->boxRepositoryMock, $this->boxSectionsRepositoryMock);
        $adjustCurrentSection->adjust($this->boxMock);
    }
}
