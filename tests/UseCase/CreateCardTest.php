<?php

use Krauza\Core\UseCase\CreateCard;
use Krauza\Core\Repository\CardRepository;
use Krauza\Core\Entity\Card;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Entity\Box;

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

        $boxService = new CreateCard($cardRepositoryMock, $boxRepositoryMock, $idMock);
        $card = $boxService->add($data);

        $boxMock = $this->getMockBuilder(Box::class)->disableOriginalConstructor()->getMock();
        $boxService->addToBox($card, $boxMock);

        $this->assertInstanceOf(Card::class, $card);
    }
}
