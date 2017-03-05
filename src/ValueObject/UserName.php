<?php

namespace Krauza\ValueObject;

use Krauza\Exception\ValueHasWrongChars;
use Krauza\Exception\ValueIsTooShort;
use Krauza\Exception\ValueIsTooLong;

class UserName
{
    private const ALLOWED_CHARS = '/[^a-zA-Z0-9]+/';
    private const MIN_NAME_LENGTH = 3;
    private const MAX_NAME_LENGTH = 48;

    private $userName;

    public function __construct(string $userName)
    {
        $this->checkUserNameChars($userName);
        $this->checkUserNameLength($userName);

        $this->userName = $userName;
    }

    private function checkUserNameChars($userName)
    {
        if (preg_match(self::ALLOWED_CHARS, $userName)) {
            throw new ValueHasWrongChars;
        }
    }

    private function checkUserNameLength($userName)
    {
        $nameLength = strlen($userName);

        if ($nameLength < self::MIN_NAME_LENGTH) {
            throw new ValueIsTooShort;
        }

        if ($nameLength > self::MAX_NAME_LENGTH) {
            throw new ValueIsTooLong;
        }
    }

    public function __toString()
    {
        return $this->userName;
    }
}
