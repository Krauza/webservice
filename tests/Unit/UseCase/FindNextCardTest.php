<?php

use Krauza\Core\UseCase\FindNextCard;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\BoxSectionsRepository;
use Krauza\Core\Repository\CardRepository;
use Krauza\Core\Entity\Box;

class FindNextCardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxSectionsRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $cardRepositoryMock;

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
        $this->cardRepositoryMock = $this->getMock(CardRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
    }

    public function mockGetCard()
    {
        $this->boxSectionsRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtCurrentSection')
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
        $this->boxRepositoryMock->expects($this->never())->method('updateBoxSection');
        $findNextCard = new FindNextCard($this->boxSectionsRepositoryMock, $this->cardRepositoryMock);
        $findNextCard->find($this->boxMock);
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenBoxHasNoCards()
    {
        $this->boxSectionsRepositoryMock->expects($this->once())
            ->method('getFirstCardFromBoxAtCurrentSection')
            ->with($this->boxMock)
            ->willReturn(null);

        $this->boxMock->method('getCurrentSection')->willReturn(0);
        $findNextCard = new FindNextCard($this->boxSectionsRepositoryMock, $this->cardRepositoryMock);
        $this->assertNull($findNextCard->find($this->boxMock));
    }
}
