<?php

use Krauza\ValueObject\UserEmail;

class UserEmailTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateUserEmail()
    {
        $name = 'test@test.test';
        $userName = new UserEmail($name);
        $this->assertEquals($name, (string) $userName);
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueHasWrongFormat
     */
    public function shouldThrowExceptionWhenEmailAddressHasNotLocalPart()
    {
        new UserEmail('@test.test');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueHasWrongFormat
     */
    public function shouldThrowExceptionWhenEmailAddressHasWrongExtensionPart()
    {
        new UserEmail('test@test.');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueHasWrongFormat
     */
    public function shouldThrowExceptionWhenEmailAddressHasNotDomainPart()
    {
        new UserEmail('test@');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueHasWrongFormat
     */
    public function shouldThrowExceptionWhenEmailAddressHasNotAt()
    {
        new UserEmail('testtesttest');
    }
}
