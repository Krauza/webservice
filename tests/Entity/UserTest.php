<?php

use Krauza\Entity\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userShouldHasCorrectFields()
    {
        $userName = $this->getMockBuilder(Krauza\ValueObject\UserName::class)->disableOriginalConstructor()->getMock();
        $userPass = $this->getMock(Krauza\Policy\PasswordPolicy::class);
        $userMail = 'test@test.test';

        $user = new User($userName, $userPass, $userMail);
        $this->assertEquals($userName, $user->getName());
        $this->assertEquals($userMail, $user->getEmail());
    }
}
