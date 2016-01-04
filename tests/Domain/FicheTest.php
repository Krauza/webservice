<?php

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;

/**
 * Class FicheTest
 *
 * @property Fiche $fiche
 */
class FicheTest extends PHPUnit_Framework_TestCase
{
    private $user;
    private $group;
    private $fiche;
    private $word;
    private $explain;
    private $ficheId;

    protected function setUp()
    {
        $this->user = new User(1, 'Username', 'test@test.test', 'password');
        $this->group = new Group(1, $this->user, 'Group name');

        $this->ficheId = 1;
        $this->word = 'Word';
        $this->explain = 'Słowo';

        $this->fiche = new Fiche($this->ficheId, $this->group, $this->word, $this->explain);
    }

    /**
     * @test
     */
    public function ficheHasCorrectId()
    {
        $this->assertEquals($this->ficheId, $this->fiche->getId());
    }

    /**
     * @test
     */
    public function ficheHasCorrectGroup()
    {
        $this->assertEquals($this->group, $this->fiche->getGroup());
    }

    /**
     * @test
     */
    public function ficheHasCorrectWord()
    {
        $this->assertEquals($this->word, $this->fiche->getWord());
    }

    /**
     * @test
     */
    public function ficheHasCorrectExmplain()
    {
        $this->assertEquals($this->explain, $this->fiche->getExplainWord());
    }

    /**
     * @test
     */
    public function tooLongWordShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= Fiche::MAX_WORD_LENGTH; $i++) {
            $str .= 'a';
        }

        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
        $this->fiche->setWord($str);
    }

    /**
     * @test
     */
    public function tooLongExplainShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= Fiche::MAX_EXPLAIN_LENGTH; $i++) {
            $str .= 'a';
        }

        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
        $this->fiche->setExplainWord($str);
    }
}
