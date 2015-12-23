<?php

use Fiche\Domain\Entity\Group;

class GroupTest extends PHPUnit_Framework_TestCase
{
    private $groupName;
    private $groupId;
    private $group;

    protected function setUp()
    {
        $this->groupName = 'group';
        $this->groupId = 1;
        $this->group = new Group($this->groupId, $this->groupName);
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
}
