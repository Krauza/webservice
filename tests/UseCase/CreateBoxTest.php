<?php

use Krauza\Core\UseCase\CreateBox;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;
use Krauza\Core\Entity\User;

class CreateBoxTest extends PHPUnit_Framework_TestCase
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

        $boxService = new CreateBox($boxRepositoryMock, $idMock);
        $boxService->add($data, $userMock);
    }
}
