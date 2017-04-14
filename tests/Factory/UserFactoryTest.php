<?php

use Krauza\Core\Entity\User;
use Krauza\Core\Factory\UserFactory;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;

class UserFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userFactoryShouldReturnUserObject()
    {
        $idMock = $this->getMock(IdPolicy::class);
        $idMock->method('generate')->willReturn(new EntityId('1'));
        $passwordMock = $this->getMock(Krauza\Core\Policy\PasswordPolicy::class);
        $data = [
            'name' => 'User',
            'email' => 'test@test.test'
        ];

        $user = UserFactory::createUser($data, $passwordMock, $idMock);
        $this->assertInstanceOf(User::class, $user);
    }
}
