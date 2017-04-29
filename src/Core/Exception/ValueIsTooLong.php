<?php

namespace Krauza\Core\Exception;

class ValueIsTooLong extends FieldException
{
    public function __construct($field)
    {
        parent::__construct($field, 'Value is too long');
    }
}
