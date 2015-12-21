<?php

namespace Fiche\Domain\Service\Exceptions;

class ValueIsTooLong extends DataNotValid
{
	protected $message = 'Value is too long';
}
