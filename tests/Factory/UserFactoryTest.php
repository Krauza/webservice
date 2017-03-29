<?php

use Krauza\Entity\User;
use Krauza\Factory\UserFactory;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\EntityId;

class UserFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userFactoryShouldReturnUserObject()
    {
        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));
        $passwordMock = $this->getMock(Krauza\Policy\PasswordPolicy::class);
        $data = [
            'name' => 'User',
            'email' => 'test@test.test'
        ];

        $user = UserFactory::createUser($data, $passwordMock, $idMock);
        $this->assertInstanceOf(User::class, $user);
    }
}
