<?php

use Krauza\Service\AddNewCardService;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Card;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;

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

        $boxService = new AddNewCardService($cardRepositoryMock, $idMock);
        $card = $boxService->addNewCard($data);

        $this->assertInstanceOf(Card::class, $card);
    }
}
