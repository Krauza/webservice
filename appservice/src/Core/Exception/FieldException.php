<?php

namespace Krauza\Core\Exception;

abstract class FieldException extends \Exception
{
    protected $fieldName;
    protected $message;

    public function __construct($field, $message)
    {
        $this->fieldName = $field;
        $this->message = $message;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }
}
