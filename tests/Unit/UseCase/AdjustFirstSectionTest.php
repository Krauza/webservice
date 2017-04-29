<?php

use Krauza\Core\Repository\BoxRepository;
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
        $this->boxRepositoryMock = $this->getMock(BoxRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldMoveMoreCardsFromInboxWhenFirstSectionIsEmpty()
    {
        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $this->boxRepositoryMock->expects($this->any())
            ->method('getNumberOfCardsInSection')->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(0)
            ))
            ->willReturn(4);

        $this->boxRepositoryMock->expects($this->once())
            ->method('moveCardsFromInboxToFirstSection')->with(Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);

        $adjustFirstSection = new AdjustFirstSection($this->boxRepositoryMock);
        $adjustFirstSection->adjust($this->boxMock);
    }
}
