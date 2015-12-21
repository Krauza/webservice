<?php

namespace Fiche\Domain\Service\Exceptions;

class DataNotValid extends \Exception
{
	protected $fieldName;

	public function __construct($fieldName) {
		$this->fieldName = $fieldName;

		parent::__construct();
	}

	public function getFieldName()
	{
		return $this->fieldName;
	}
}
