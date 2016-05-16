<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupUser.php');

use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\Email;
use Fiche\Domain\ValueObject\UserName;

/**
 * Class UserTest
 *
 * @property User $user;
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    use SetupUser;

    protected function setUp()
    {
        $this->setupUser();
    }

    /**
     * @test
     */
    public function userShouldHasId()
    {
        $this->assertEquals($this->userId, $this->user->getId());
    }

    /**
     * @test
     */
    public function userShouldHasName()
    {
        $this->assertEquals((string)$this->userName, $this->user->getName());
    }

    /**
     * @test
     */
    public function changeUserNameShouldBePossible()
    {
        $newName = new UserName('New user name');
        $this->user->setName($newName);

        $this->assertEquals($newName, $this->user->getName());
    }

    /**
     * @test
     */
    public function userShouldHasEmail()
    {
        $this->assertEquals($this->email, $this->user->getEmail());
    }

    /**
     * @test
     */
    public function changeUserEmailShouldBePossible()
    {
        $newEmail = new Email('test2@test.test');
        $this->user->setEmail($newEmail);

        $this->assertEquals($newEmail, $this->user->getEmail());
    }

    /**
     * @test
     */
    public function userShouldHasPassword()
    {
        $this->assertEquals($this->password, $this->user->getPassword());
    }

    /**
     * @test
     */
    public function changeUserPasswordShouldBePossible()
    {
        $newPassword = 'dfdsf';
        $this->user->setPassword($newPassword);

        $this->assertEquals($newPassword, $this->user->getPassword());
    }

    /**
     * @test
     */
    public function getUserGroupsShouldBePossible()
    {
        $this->assertInstanceOf('Fiche\Domain\Service\UserGroupsCollection', $this->user->getUserGroups());
    }
}
