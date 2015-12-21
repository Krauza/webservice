<?php

namespace Fiche\Domain\Service\Exceptions;

class FieldIsRequired extends DataNotValid
{
	protected $message = 'Field is required';
}
