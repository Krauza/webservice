<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupGroup.php');
require_once(__DIR__ . '/../../traits/SetupFiche.php');

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\Service\FichesCollection;
use Fiche\Domain\ValueObject\GroupName;

/**
 * Class GroupTest
 *
 * @property User $user;
 * @property Group $group;
 */
class GroupTest extends PHPUnit_Framework_TestCase
{
    use SetupGroup, SetupFiche;

    protected function setUp()
    {
        $this->setupGroup();
    }

    /**
     * @test
     */
    public function groupShouldHasId()
    {
        $this->assertEquals($this->groupId, $this->group->getId());
    }

    /**
     * @test
     */
    public function groupShouldHasName()
    {
        $this->assertEquals($this->groupName, $this->group->getName());
    }

    /**
     * @test
     */
    public function changeGroupNameShouldBePossible()
    {
        $name = new GroupName('name');
        $this->group->setName($name);
        $this->assertEquals($name, $this->group->getName());
    }

    /**
     * @test
     */
    public function groupShouldHasOwner()
    {
        $this->assertEquals($this->user, $this->group->getOwner());
    }

    /**
     * @test
     */
    public function addFicheToGroupShouldWork()
    {
        $this->setupFiche($this->group);
        $this->group->addFiche($this->fiche);

        $fiches = $this->group->getFiches();
        $this->assertInstanceOf(FichesCollection::class, $fiches);
        $this->assertCount(1, $fiches);
    }

    /**
     * @test
     */
    public function groupShouldHasFichesCollection()
    {
        $this->assertInstanceOf(FichesCollection::class, $this->group->getFiches());
    }

    /**
     * @test
     */
    public function groupShouldHasOwnerInfo()
    {
        $this->assertInternalType('bool', $this->group->isOwner($this->user));
    }
}
