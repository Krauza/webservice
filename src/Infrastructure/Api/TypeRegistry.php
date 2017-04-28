<?php

namespace Krauza\Infrastructure\Api;

use Krauza\Infrastructure\Api\Type\CreateBoxType;
use Krauza\Infrastructure\Api\Type\ErrorType;
use Krauza\Infrastructure\Api\Type\MutationType;
use Krauza\Infrastructure\Api\Type\QueryType;
use Krauza\Infrastructure\Api\Type\BoxType;

class TypeRegistry
{
    private static $boxType;
    private static $queryType;
    private static $mutationType;
    private static $errorType;
    private static $createBoxType;

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

    public static function getErrorType(): ErrorType
    {
        return self::$errorType ?: (self::$errorType = new ErrorType);
    }

    public static function getCreateBoxType(): CreateBoxType
    {
        return self::$createBoxType ?: (self::$createBoxType = new CreateBoxType);
    }
}
