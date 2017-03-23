<?php

use Krauza\Service\AddNewCardService;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;
use Krauza\Entity\Box;

class AddNewCardServiceTest extends PHPUnit_Framework_TestCase
{
//    /**
//     * @test
//     */
    public function shouldAddNewCardToInbox()
    {
        $data = [
            'obverse' => 'first',
            'reverse' => 'second'
        ];

        $cardRepositoryMock = $this->getMock(CardRepository::class);
        $cardRepositoryMock->expects($this->once())->method('add');

        $boxRepositoryMock = $this->getMock(BoxRepository::class);
        $boxRepositoryMock->expects($this->once())->method('addCardToInbox');

        $boxService = new AddNewCardService($boxRepositoryMock);
        $boxService->addNewCardToBox(new Box, $data);
    }
}
