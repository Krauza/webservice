<?php

use Krauza\Core\Entity\Box;
use Krauza\Core\ValueObject\BoxName;
use Krauza\Core\ValueObject\EntityId;

class BoxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Box
     */
    private $box;

    public function setUp()
    {
        $this->box = new Box(new BoxName('name'));
        $this->box->setId(new EntityId('1'));
    }
    /**
     * @test
     */
    public function boxShouldBeCreatable()
    {
        $this->assertEquals('name', $this->box->getName());
        $this->assertEquals('1', $this->box->getId());
    }

    /**
     * @test
     */
    public function shouldIncrementSection()
    {
        $this->box->incrementCurrentSection();
        $this->assertEquals(1, $this->box->getCurrentSection());
    }

    /**
     * @test
     */
    public function shouldRewindToFirstSection()
    {
        $box = new Box(new BoxName('name'), 3);
        $box->rewindToFirstSection();
        $this->assertEquals(0, $box->getCurrentSection());
    }

    /**
     * @test
     */
    public function shouldSetSection()
    {
        $this->box->setCurrentSection(4);
        $this->assertEquals(4, $this->box->getCurrentSection());
    }
}
