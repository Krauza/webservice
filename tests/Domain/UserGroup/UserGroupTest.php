<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupUserGroup.php');

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\UserFichesCollection;

/**
 * Class UserGroupTest
 *
 * @property Group $group
 * @property UserGroup $userGroup
 */
class UserGroupTest extends PHPUnit_Framework_TestCase
{
    use SetupUserGroup;

    public function setUp()
    {
        $this->setupUserGroup();
    }

    /**
     * @test
     */
    public function shouldHasCorrectUser()
    {
        $this->assertEquals($this->user, $this->userGroup->getUser());
    }

    /**
     * @test
     */
    public function shouldHasCorrectGroup()
    {
        $this->assertEquals($this->group, $this->userGroup->getGroup());
    }

    /**
     * @test
     */
    public function shouldReturnUserFichesCollection()
    {
        $this->assertInstanceOf(UserFichesCollection::class, $this->userGroup->getUserFichesCollection());
    }

    /**
     * @test
     */
    public function nextFicheShouldReturnNullFromEmptyCollection()
    {
        $this->assertEmpty($this->userGroup->getNextFiche());
    }
}
