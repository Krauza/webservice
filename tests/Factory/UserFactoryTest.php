<?php

use Krauza\Entity\User;
use Krauza\Factory\UserFactory;

class UserFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userFactoryShouldReturnUserObject()
    {
        $passwordMock = $this->getMock(Krauza\Policy\PasswordPolicy::class);
        $data = [
            'name' => 'User',
            'email' => 'test@test.test'
        ];

        $user = UserFactory::createUser($data, $passwordMock);
        $this->assertInstanceOf(User::class, $user);
    }
}
