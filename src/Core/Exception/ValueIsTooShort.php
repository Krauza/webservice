<?php

namespace Krauza\Core\Exception;

class ValueIsTooShort extends FieldException
{
    public function __construct($field)
    {
        parent::__construct($field, 'Value is too short');
    }
}
