<?php

use Krauza\Entity\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userShouldHasCorrectFields()
    {
        $userName = 'name';
        $userNameStub = $this->createStub(Krauza\ValueObject\UserName::class, $userName);

        $userEmail = 'test@test.test';
        $userMailStub = $this->createStub(Krauza\ValueObject\UserEmail::class, $userEmail);

        $userPassStub = $this->getMock(Krauza\Policy\PasswordPolicy::class);

        $user = new User($userNameStub, $userPassStub, $userMailStub);
        $this->assertEquals($userName, $user->getName());
        $this->assertEquals($userEmail, $user->getEmail());
    }

    function createStub($className, $returnValue)
    {
        $userMailStub = $this->getMockBuilder($className)->disableOriginalConstructor()->getMock();
        $userMailStub->method('__toString')->willReturn($returnValue);
        return $userMailStub;
    }
}
