<?php

declare(strict_types=1);
require_once(__DIR__ . '/../traits/NameGenerator.php');

class BaseValueObjectTestCase extends PHPUnit_Framework_TestCase
{
    protected $className;
    protected $maxLength;

    /**
     * @test
     */
    public function shouldReturnCorrectValue()
    {
        $name = 'Value';
        $object = new $this->className($name);
        $this->assertEquals($name, $object);
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\FieldIsRequired
     */
    public function emptyValueShouldThrownError()
    {
        new $this->className('');
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsTooLong
     */
    public function tooLongValueShouldThrownError()
    {
        new $this->className(NameGenerator::greaterThan($this->maxLength));
    }
}
