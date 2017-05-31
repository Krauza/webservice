<?php

namespace Krauza\Core\Exception;

class ValueHasWrongChars extends FieldException
{
    public function __construct($field)
    {
        parent::__construct($field, 'Value has incorrect symbols');
    }
}
