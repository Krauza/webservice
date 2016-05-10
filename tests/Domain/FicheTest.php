<?php

declare(strict_types=1);
require_once('traits/SetupGroup.php');

use Fiche\Domain\Entity\Fiche;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\ValueObject\FicheWord;
use Fiche\Domain\ValueObject\FicheExplain;
use Fiche\Domain\Entity\Attachment;

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
    private $attachment;

    protected function setUp()
    {
        $this->setupGroup();

        $this->ficheId = new UniqueId();
        $this->word = new FicheWord('word');
        $this->explain = new FicheExplain('słowo');
        $this->attachment = new Attachment('file.jpg', 'dir');

        $this->fiche = new Fiche($this->ficheId, $this->group, $this->word, $this->explain, $this->attachment);
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
    public function ficheHasCorrectExplain()
    {
        $this->assertEquals($this->explain, $this->fiche->getExplainWord());
    }

    /**
     * @test
     */
    public function ficheHasCorrectAttachment()
    {
        $this->assertEquals($this->attachment, $this->fiche->getAttachment());
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\FieldIsRequired
     */
    public function emptyWordShouldThrownError()
    {
        new FicheWord('');
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsTooLong
     */
    public function tooLongWordShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= FicheWord::MAX_WORD_LENGTH; $i++) {
            $str .= 'a';
        }

        new FicheWord($str);
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\FieldIsRequired
     */
    public function emptyExplainNameShouldThrownError()
    {
        new FicheExplain('');
    }

    /**
     * @test
     * @expectedException Fiche\Domain\Service\Exceptions\ValueIsTooLong
     */
    public function tooLongExplainShouldThrownError()
    {
        $str = '';
        for($i = 0; $i <= FicheExplain::MAX_EXPLAIN_LENGTH; $i++) {
            $str .= 'a';
        }

        new FicheExplain($str);
    }
}
