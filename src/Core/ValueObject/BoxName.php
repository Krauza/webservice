<?php

namespace Krauza\Core\ValueObject;

use Krauza\Core\Exception\ValueIsTooShort;
use Krauza\Core\Exception\ValueIsTooLong;

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
            throw new ValueIsTooShort((new \ReflectionClass($this))->getShortName());
        }

        if ($nameLength > self::MAX_NAME_LENGTH) {
            throw new ValueIsTooLong((new \ReflectionClass($this))->getShortName());
        }
    }

    public function __toString()
    {
        return $this->boxName;
    }
}
