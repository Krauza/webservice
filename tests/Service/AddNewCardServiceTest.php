<?php

use Krauza\Service\NewCardService;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Card;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;
use Krauza\Repository\BoxRepository;
use Krauza\Entity\Box;

class AddNewCardServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldAddNewCard()
    {
        $data = [
            'obverse' => 'first',
            'reverse' => 'second'
        ];

        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));

        $cardRepositoryMock = $this->getMock(CardRepository::class);
        $cardRepositoryMock->expects($this->once())->method('add');

        $boxRepositoryMock = $this->getMock(BoxRepository::class);
        $boxRepositoryMock->expects($this->once())->method('addCardToInbox');

        $boxService = new NewCardService($cardRepositoryMock, $boxRepositoryMock, $idMock);
        $card = $boxService->addNewCard($data);

        $boxMock =$this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
        $boxService->addCardToBox($card, $boxMock);

        $this->assertInstanceOf(Card::class, $card);
    }
}
