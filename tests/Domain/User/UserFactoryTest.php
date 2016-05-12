<?php

declare(strict_types=1);

use Fiche\Domain\Entity\User;
use Fiche\Domain\Factory\UserFactory;

class UserFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function factoryShouldPrepareCorrectEntity()
    {
        $mockUniqueId = $this->getMock('Fiche\Domain\Policy\UniqueIdInterface');
        $mockUserGroupsRepository = $this->getMock('Fiche\Domain\Repository\UserGroupsRepository');

        $id = new $mockUniqueId();
        $userGroupsRepository = new $mockUserGroupsRepository();
        $name = 'User';
        $email = 'test@test.test';
        $password = 'pass';

        $user = UserFactory::create($id, $name, $email, $password, $userGroupsRepository);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($email, $user->getEmail());
    }
}
