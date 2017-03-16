<?php

namespace Krauza\ValueObject;

use Krauza\Exception\ValueIsTooShort;
use Krauza\Exception\ValueIsTooLong;

class CardWord
{
    private const MIN_WORD_LENGTH = 2;
    private const MAX_WORD_LENGTH = 512;

    private $cardWord;

    public function __construct(string $cardWord)
    {
        $cardWordLength = strlen($cardWord);

        if ($cardWordLength < self::MIN_WORD_LENGTH) {
            throw new ValueIsTooShort;
        }

        if ($cardWordLength > self::MAX_WORD_LENGTH) {
            throw new ValueIsTooLong;
        }

        $this->cardWord = $cardWord;
    }

    public function __toString()
    {
        return $this->cardWord;
    }
}
