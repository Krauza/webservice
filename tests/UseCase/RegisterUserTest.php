<?php

use Krauza\Core\UseCase\RegisterUser;
use Krauza\Core\Repository\UserRepository;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;

class RegistrationServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registrationServiceShouldAddNewUser()
    {
        $data = [
            'name' => 'user',
            'password' => 'password',
            'email' => 'test@test.tes'
        ];

        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));

        $userRepositoryMock = $this->getMock(UserRepository::class);
        $userRepositoryMock->expects($this->once())->method('add');

        $passwordMock = $this->getMock(Krauza\Core\Policy\PasswordPolicy::class);

        $registrationService = new RegisterUser($userRepositoryMock, $passwordMock, $idMock);
        $registrationService->register($data);
    }
}
