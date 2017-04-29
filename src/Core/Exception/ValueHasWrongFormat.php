<?php

namespace Krauza\Core\Exception;

class ValueHasWrongFormat extends FieldException
{
    public function __construct($field)
    {
        parent::__construct($field, 'Value has incorrect format');
    }
}
