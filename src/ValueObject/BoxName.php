<?php

namespace Krauza\ValueObject;

use Krauza\Exception\ValueIsTooShort;
use Krauza\Exception\ValueIsTooLong;

class BoxName
{
    private const MIN_NAME_LENGTH = 3;
    private const MAX_NAME_LENGTH = 128;

    private $boxName;

    public function __construct(string $boxName)
    {
        $this->checkBoxNameLength($boxName);
        $this->boxName = $boxName;
    }


    private function checkBoxNameLength($boxName)
    {
        $nameLength = strlen($boxName);

        if ($nameLength < self::MIN_NAME_LENGTH) {
            throw new ValueIsTooShort;
        }

        if ($nameLength > self::MAX_NAME_LENGTH) {
            throw new ValueIsTooLong;
        }
    }

    public function __toString()
    {
        return $this->boxName;
    }
}