<?php

use Fiche\Domain\Entity\User;
use Fiche\Domain\ValueObject\Email;

/**
 * Class UserTest
 *
 * @property User $user;
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    private $userId;
    private $userName;
    private $email;
    private $password;
    private $user;

    protected function setUp()
    {
        $this->userId = 1;
        $this->userName = 'User';
        $this->email = 'test@test.test';
        $this->password = 'D3F$##$F3VWCA#CVFH^&^4&M9';

        $this->user = new User($this->userId, $this->userName, new Email($this->email), $this->password);
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
