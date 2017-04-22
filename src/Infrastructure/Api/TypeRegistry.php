<?php

namespace Krauza\Infrastructure\Api;

use Krauza\Infrastructure\Api\Type\MutationType;
use Krauza\Infrastructure\Api\Type\QueryType;
use Krauza\Infrastructure\Api\Type\BoxType;

class TypeRegistry
{
    private static $boxType;
    private static $queryType;
    private static $mutationType;

    public static function getQueryType(): QueryType
    {
        return self::$queryType ?: (self::$queryType = new QueryType);
    }

    public static function getMutationType(): MutationType
    {
        return self::$mutationType ?: (self::$mutationType = new MutationType());
    }

    public static function getBoxType(): BoxType
    {
        return self::$boxType ?: (self::$boxType = new BoxType);
    }
}
