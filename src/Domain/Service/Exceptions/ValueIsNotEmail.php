<?php

namespace Fiche\Domain\Service\Exceptions;

class ValueIsNotEmail extends DataNotValid
{
	protected $message = 'The specified value is not a valid email address';
}
