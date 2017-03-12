<?php

use Krauza\Entity\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    private $userName;
    private $userNameStub;
    private $user;

    public function setUp()
    {
        $this->userName = 'name';
        $this->userNameStub = $this->createStub(Krauza\ValueObject\UserName::class, $this->userName);
        $this->user = new User($this->userNameStub);
        $this->user->setPassword('pass');
    }

    /**
     * @test
     */
    public function userShouldBeCreatableWithUserName()
    {
        $this->assertEquals($this->userName, $this->user->getName());
    }

    /**
     * @test
     */
    public function userShouldHavePossibilityToSetEmail()
    {
        $userEmail = 'test@test.test';
        $userMailStub = $this->createStub(Krauza\ValueObject\UserEmail::class, $userEmail);

        $this->user->setEmail($userMailStub);
        $this->assertEquals($userEmail, $this->user->getEmail());
    }

    function createStub($className, $returnValue)
    {
        $userMailStub = $this->getMockBuilder($className)->disableOriginalConstructor()->getMock();
        $userMailStub->method('__toString')->willReturn($returnValue);
        return $userMailStub;
    }
}
