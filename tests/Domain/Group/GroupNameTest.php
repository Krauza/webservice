<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\GroupName;

class GroupNameTest extends BaseValueObjectTestCase
{
    public function setUp()
    {
        $this->className = GroupName::class;
        $this->maxLength = GroupName::NAME_MAX_LENGTH;
    }
}
