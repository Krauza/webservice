<?php

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\Email;

/**
 * Class GroupTest
 *
 * @property User $user;
 * @property Group $group;
 */
class GroupTest extends PHPUnit_Framework_TestCase
{
    private $groupName;
    private $groupId;
    private $group;
    private $user;

    protected function setUp()
    {
        $this->groupName = 'group';
        $this->groupId = 1;
        $this->user = new User(1, 'User', new Email('test@test.test'), 'password');
        $this->group = new Group($this->groupId, $this->user, $this->groupName);
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
     */
    public function emptyNameShouldThrownError()
    {
        $this->setExpectedException('Fiche\Domain\Service\Exceptions\FieldIsRequired');
        $this->group->setName('');
    }

    /**
     * @test
     */
    public function tooLongNameShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= Group::NAME_MAX_LENGTH; $i++) {
            $str .= 'a';
        }

        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
        $this->group->setName($str);
    }

    /**
     * @test
     */
    public function groupHasCorrectOwner()
    {
        $this->assertEquals($this->user, $this->group->getOwner());
    }
}
