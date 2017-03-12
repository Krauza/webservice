<?php

use Krauza\Service\RegistrationService;
use Krauza\Repository\UserRepository;

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

        $userRepositoryMock = $this->getMock(UserRepository::class);
        $userRepositoryMock->expects($this->once())->method('add');

        $passwordMock = $this->getMock(Krauza\Policy\PasswordPolicy::class);

        $registrationService = new RegistrationService($userRepositoryMock, $passwordMock);
        $registrationService->register($data);
    }
}
