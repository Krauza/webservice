<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\FicheExplain;

class FicheExplainTest extends BaseValueObjectTestCase
{
    public function setUp()
    {
        $this->className = FicheExplain::class;
        $this->maxLength = FicheExplain::MAX_EXPLAIN_LENGTH;
    }
}
