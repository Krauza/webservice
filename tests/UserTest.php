<?php

declare(strict_types=1);
require_once('SetupUser.php');

use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\Email;

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
    public function userIdIsSet()
    {
        $this->assertEquals($this->userId, $this->user->getId());
    }

    /**
     * @test
     */
    public function userNameIsSet()
    {
        $this->assertEquals($this->userName, $this->user->getName());
    }

    /**
     * @test
     */
    public function userEmailIsSet()
    {
        $this->assertEquals($this->email, $this->user->getEmail());
    }

    /**
     * @test
     */
    public function userPasswordIsSet()
    {
        $this->assertEquals($this->password, $this->user->getPassword());
    }

    /**
     * @test
     */
    public function tooShortEmailShouldThrownError()
    {
        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooShort');
        $this->user->setEmail(new Email(''));
    }

    /**
     * @test
     */
    public function tooLongEmailShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= Email::EMAIL_MAX_LENGTH; $i++) {
            $str .= 'a';
        }

        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
        $this->user->setEmail(new Email($str . '@test.test'));
    }

    /**
     * @test
     */
    public function wrongEmailShouldThrownError()
    {
        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsNotEmail');
        $this->user->setEmail(new Email('wrong@email'));
        $this->user->setEmail(new Email('wrong'));
    }
}
