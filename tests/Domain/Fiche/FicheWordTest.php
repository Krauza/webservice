<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\FicheWord;

class FicheWordTest extends BaseValueObjectTestCase
{
    public function setUp()
    {
        $this->className = FicheWord::class;
        $this->maxLength = FicheWord::MAX_WORD_LENGTH;
    }
}
