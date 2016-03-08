<?php

declare(strict_types=1);
require_once('SetupGroup.php');

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;

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

//    /**
//     * @test
//     */
//    public function emptyNameShouldThrownError()
//    {
//        $this->setExpectedException('Fiche\Domain\Service\Exceptions\FieldIsRequired');
//        $this->group->setName('');
//    }

//    /**
//     * @test
//     */
//    public function tooLongNameShouldThrownError()
//    {
//        $str = '';
//        for($i = 0; $i <= GroupName::NAME_MAX_LENGTH; $i++) {
//            $str .= 'a';
//        }
//
//        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
//        $this->group->setName($str);
//    }

    /**
     * @test
     */
    public function groupHasCorrectOwner()
    {
        $this->assertEquals($this->user, $this->group->getOwner());
    }
}
