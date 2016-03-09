<?php

namespace Fiche\Domain\ValueObject;

use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class FicheWord
{
	const MAX_WORD_LENGTH = 255;

	private $word;

	public function __construct($word)
	{
		$word = trim($word);
		if (empty($word)) {
			throw new FieldIsRequired('word');
		}

		if (strlen($word) > self::MAX_WORD_LENGTH) {
			throw new ValueIsTooLong('word');
		}

		$this->word = $word;
	}

	public function __toString() {
		return $this->word;
	}
}
