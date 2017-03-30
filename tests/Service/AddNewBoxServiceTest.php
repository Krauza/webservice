<?php

use Krauza\Service\AddNewBoxService;
use Krauza\Repository\BoxRepository;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;

class AddNewBoxServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldAddNewBox()
    {
        $data = [
            'name' => 'box name'
        ];

        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));

        $boxRepositoryMock = $this->getMock(BoxRepository::class);
        $boxRepositoryMock->expects($this->once())->method('add');

        $boxService = new AddNewBoxService($boxRepositoryMock, $idMock);
        $boxService->addNewBox($data);
    }
}
