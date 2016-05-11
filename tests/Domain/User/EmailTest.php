<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\Email;

class EmailTest extends BaseValueObjectTestCase
{
    public function setUp()
    {
        $this->className = Email::class;
        $this->maxLength = Email::EMAIL_MAX_LENGTH;
    }

    /**
     * @test
     */
    public function shouldReturnCorrectValue()
    {
        $name = 'test@test.test';
        $object = new $this->className($name);
        $this->assertEquals($name, $object);
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsTooShort
     */
    public function tooShortEmailShouldThrownError()
    {
        new Email(NameGenerator::correct(Email::EMAIL_MIN_LENGTH - 1));
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsNotEmail
     */
    public function wrongEmailShouldThrownError()
    {
        new Email('wrong@email');
    }
}
