<?php

use Krauza\UseCase\AddAnswer;
use Krauza\Repository\BoxRepository;
use Krauza\Entity\Box;
use Krauza\Entity\Card;

class AddAnswerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $cardMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $boxMock;

    /**
     * @var AddAnswer
     */
    private $addAnswer;

    public function setUp()
    {
        $this->boxRepositoryMock = $this->getMock(BoxRepository::class);
        $this->boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
        $this->cardMock = $this->getMockBuilder(Card::class)->disableOriginalConstructor()->getMock();
        $this->addAnswer = new AddAnswer($this->boxRepositoryMock);
    }

    /**
     * @test
     */
    public function shouldMoveCardToNextSectionWhenAnswerIsCorrect()
    {
        $this->boxRepositoryMock->expects($this->once())->method('getBoxSectionByCard')->willReturn(0);
        $this->boxRepositoryMock->expects($this->once())->method('moveCardBetweenBoxSections')
            ->with(0, 1, $this->boxMock, $this->cardMock);

        $this->addAnswer->answer(true, $this->boxMock, $this->cardMock);
    }

    /**
     * @test
     */
    public function shouldBackToFirstSectionWhenAnswerIsWrong()
    {
        $this->boxRepositoryMock->expects($this->once())->method('getBoxSectionByCard')->willReturn(3);
        $this->boxRepositoryMock->expects($this->once())->method('moveCardBetweenBoxSections')
            ->with(3, 0, $this->boxMock, $this->cardMock);

        $this->addAnswer->answer(false, $this->boxMock, $this->cardMock);
    }

    /**
     * @test
     */
    public function setCardAsArchivedWhenAnswerIsCorrectAndCardIsInLastSection()
    {
        $this->boxRepositoryMock->expects($this->once())->method('getBoxSectionByCard')->willReturn(4);
        $this->boxRepositoryMock->expects($this->once())->method('setCardAsArchived')
            ->with($this->boxMock, $this->cardMock);

        $this->addAnswer->answer(true, $this->boxMock, $this->cardMock);
    }
}
