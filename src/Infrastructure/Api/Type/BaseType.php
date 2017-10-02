<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;

abstract class BaseType extends ObjectType
{
    protected static $instance;

    public function __construct()
    {
        parent::__construct($this->getConfig());
    }

    public static function getInstance()
    {
        return static::$instance ?: (static::$instance = new static);
    }

    protected abstract function getConfig(): array;
}
