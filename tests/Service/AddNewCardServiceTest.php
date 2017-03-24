<?php

use Krauza\Service\AddNewCardService;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Card;

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

        $cardRepositoryMock = $this->getMock(CardRepository::class);
        $cardRepositoryMock->expects($this->once())->method('add');

        $boxService = new AddNewCardService($cardRepositoryMock);
        $card = $boxService->addNewCard($data);

        $this->assertInstanceOf(Card::class, $card);
    }
}
