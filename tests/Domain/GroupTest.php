<?php

declare(strict_types=1);
require_once('traits/SetupGroup.php');

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\GroupName;

/**
 * Class GroupTest
 *
 * @property User $user;
 * @property Group $group;
 */
class GroupTest extends PHPUnit_Framework_TestCase
{
    use SetupGroup;

    protected function setUp()
    {
        $this->setupGroup();
    }

    /**
     * @test
     */
    public function groupIdIsSet()
    {
        $this->assertEquals($this->groupId, $this->group->getId());
    }

    /**
     * @test
     */
    public function groupNameIsSet()
    {
        $this->assertEquals($this->groupName, $this->group->getName());
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\FieldIsRequired
     */
    public function emptyNameShouldThrownError()
    {
        $groupName = new GroupName('');
        $this->setName($groupName);
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsTooLong
     */
    public function tooLongNameShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= GroupName::NAME_MAX_LENGTH; $i++) {
            $str .= 'a';
        }

        $groupName = new GroupName($str);
        $this->setName($groupName);
    }

    /**
     * @test
     */
    public function groupHasCorrectOwner()
    {
        $this->assertEquals($this->user, $this->group->getOwner());
    }
}
