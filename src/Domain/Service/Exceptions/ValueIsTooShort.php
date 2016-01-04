<?php

namespace Fiche\Domain\Service\Exceptions;

class ValueIsTooShort extends DataNotValid
{
	protected $message = 'Value is too short';
}
