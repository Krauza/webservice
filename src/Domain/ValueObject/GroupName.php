<?php

namespace Fiche\Domain\ValueObject;

use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class GroupName
{
	const NAME_MAX_LENGTH = 120;

	private $name;

	public function __construct($name)
	{
		$name = trim($name);

		if (empty($name)) {
			throw new FieldIsRequired('name');
		}

		if (strlen($name) > self::NAME_MAX_LENGTH) {
			throw new ValueIsTooLong('name');
		}

		$this->name = $name;
	}

	public function __toString() {
		return $this->name;
	}
}
