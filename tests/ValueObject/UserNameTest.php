<?php

use Krauza\ValueObject\UserName;

class UserNameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateUserName()
    {
        $name = 'testName12';
        $userName = new UserName($name);
        $this->assertEquals($name, (string) $userName);
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueHasWrongChars
     */
    public function shouldThrowExceptionWhenUserNameHaveOtherCharsThanAlphaNumeric()
    {
        new UserName('name0_');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueIsTooShort
     */
    public function shouldThrowExceptionWhenUserNameHaveNotEnoughChars()
    {
        new UserName('a');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueIsTooLong
     */
    public function shouldThrowExceptionWhenUserNameIsTooLong()
    {
        new UserName('abcdaadeas90sd87a57ds78sagdsag7d7sagdsad58gas8dsadasdas58hkjh');
    }
}
