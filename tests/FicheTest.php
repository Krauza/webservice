<?php

declare(strict_types=1);
require_once('SetupGroup.php');

use Fiche\Domain\Entity\Fiche;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\ValueObject\FicheWord;
use Fiche\Domain\ValueObject\FicheExplain;

/**
 * Class FicheTest
 *
 * @property Fiche $fiche
 */
class FicheTest extends PHPUnit_Framework_TestCase
{
    use SetupGroup;

    private $fiche;
    private $word;
    private $explain;
    private $ficheId;

    protected function setUp()
    {
        $this->setupGroup();

        $this->ficheId = new UniqueId();
        $this->word = new FicheWord('word');
        $this->explain = new FicheExplain('słowo');

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

//    /**
//     * @test
//     */
//    public function tooLongWordShouldThrownError()
//    {
//        $str = '';
//        for($i = 0; $i <= FicheWord::MAX_WORD_LENGTH; $i++) {
//            $str .= 'a';
//        }
//
//        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
//        $this->fiche->setWord($str);
//    }
//
//    /**
//     * @test
//     */
//    public function tooLongExplainShouldThrownError()
//    {
//        $str = '';
//        for($i = 0; $i <= FicheExplain::MAX_EXPLAIN_LENGTH; $i++) {
//            $str .= 'a';
//        }
//
//        $this->setExpectedException('Fiche\Domain\Service\Exceptions\ValueIsTooLong');
//        $this->fiche->setExplainWord($str);
//    }
}
