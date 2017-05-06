<?php

use Krauza\Core\Repository\BoxSectionsRepository;
use Krauza\Core\Entity\Box;
use Krauza\Core\UseCase\AdjustFirstSection;

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
        $this->boxRepositoryMock = $this->getMock(BoxSectionsRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldMoveMoreCardsFromInboxWhenFirstSectionIsEmpty()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')
            ->willReturn(4);

        $this->boxRepositoryMock->expects($this->once())
            ->method('moveCardsFromInboxToFirstSection')->with($this->boxMock, Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);

        $adjustFirstSection = new AdjustFirstSection($this->boxRepositoryMock);
        $adjustFirstSection->adjust($this->boxMock);
    }
}
