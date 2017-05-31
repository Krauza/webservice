<?php

namespace Krauza\Infrastructure\Api;

use Krauza\Infrastructure\Api\Type\CardType;
use Krauza\Infrastructure\Api\Type\CreateBoxType;
use Krauza\Infrastructure\Api\Type\CreateCardType;
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
    private static $cardType;
    private static $createCardType;

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

    public static function getCardType(): CardType
    {
        return self::$cardType ?: (self::$cardType = new CardType);
    }

    public static function getErrorType(): ErrorType
    {
        return self::$errorType ?: (self::$errorType = new ErrorType);
    }

    public static function getCreateBoxType(): CreateBoxType
    {
        return self::$createBoxType ?: (self::$createBoxType = new CreateBoxType);
    }

    public static function getCreateCardType(): CreateCardType
    {
        return self::$createCardType ?: (self::$createCardType = new CreateCardType);
    }
}
