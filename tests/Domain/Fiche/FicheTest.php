<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupGroup.php');
require_once(__DIR__ . '/../../traits/SetupFiche.php');

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;

/**
 * Class FicheTest
 *
 * @property Fiche $fiche
 * @property Group $group
 */
class FicheTest extends PHPUnit_Framework_TestCase
{
    use SetupGroup, SetupFiche;

    protected function setUp()
    {
        $this->setupGroup();
        $this->setupFiche($this->group);
    }

    /**
     * @test
     */
    public function ficheHasCorrectId()
    {
        $this->assertEquals($this->ficheId, $this->fiche->getId());
    }

    /**
     * @test
     */
    public function ficheHasCorrectGroup()
    {
        $this->assertEquals($this->group, $this->fiche->getGroup());
    }

    /**
     * @test
     */
    public function ficheHasCorrectWord()
    {
        $this->assertEquals($this->word, $this->fiche->getWord());
    }

    /**
     * @test
     */
    public function ficheHasCorrectExplain()
    {
        $this->assertEquals($this->explain, $this->fiche->getExplainWord());
    }

    /**
     * @test
     */
    public function ficheHasCorrectAttachment()
    {
        $this->assertEquals($this->attachment, $this->fiche->getAttachment());
    }
}
