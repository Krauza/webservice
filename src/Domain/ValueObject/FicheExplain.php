<?php

namespace Fiche\Domain\ValueObject;

use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class FicheExplain
{
	const MAX_EXPLAIN_LENGTH = 1000;

	private $explain_word;

	public function __construct($explain_word)
	{
		$explain_word = trim($explain_word);
		if (empty($explain_word)) {
			throw new FieldIsRequired('explain');
		}

		if (strlen($explain_word) > self::MAX_EXPLAIN_LENGTH) {
			throw new ValueIsTooLong('explain');
		}

		$this->explain_word = $explain_word;
	}

	public function __toString()
	{
		return $this->explain_word;
	}
}
