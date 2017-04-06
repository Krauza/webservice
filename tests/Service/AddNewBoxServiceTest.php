<?php

use Krauza\Service\CreateBoxService;
use Krauza\Repository\BoxRepository;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;
use Krauza\Entity\User;

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

        $userMock =$this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();

        $boxService = new CreateBoxService($boxRepositoryMock, $idMock);
        $boxService->add($data, $userMock);
    }
}
