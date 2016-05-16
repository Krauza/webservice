<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\UserName;

class UserNameTest extends BaseValueObjectTestCase
{
    public function setUp()
    {
        $this->className = UserName::class;
        $this->maxLength = UserName::NAME_MAX_LENGTH;
    }
}
