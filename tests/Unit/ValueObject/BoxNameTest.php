<?php

use Krauza\Core\ValueObject\BoxName;

class BoxNameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateBoxName()
    {
        $name = 'testName34';
        $boxName = new BoxName($name);
        $this->assertEquals($name, (string) $boxName);
    }

    /**
     * @test
     * @expectedException Krauza\Core\Exception\ValueIsTooShort
     */
    public function shouldThrowExceptionWhenBoxNameHaveNotEnoughChars()
    {
        new BoxName('a');
    }

    /**
     * @test
     * @expectedException Krauza\Core\Exception\ValueIsTooLong
     */
    public function shouldThrowExceptionBoxUserNameIsTooLong()
    {
        new BoxName('abcdaadeas90sddfwetcbvjtyrtregfchb87a57ds78sagdsag7d7sagdsad58gas8dsadasdas58hkjh55454gg454455gg54g45t45g45655665gtg5gdfgbl4fhdd54cf');
    }
}
