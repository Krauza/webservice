<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Infrastructure\Api\Type\Object\BoxType;
use Krauza\Infrastructure\Api\Type\Object\CardType;

class CreateCardType extends ObjectType
{
    private static $instance;

    public function __construct()
    {
        $config = [
            'fields' => [
                'card' => [
                    'type' => CardType::getInstance(),
                    'description' => 'Created card'
                ],
                'box' => [
                    'type' => BoxType::getInstance(),
                    'description' => 'Parent box'
                ]
            ]
        ];

        parent::__construct($config);
    }

    public static function getInstance(): self
    {
        return self::$instance ?: (self::$instance = new self);
    }

    public static function toResponseFormat(array $result): array
    {
        return [
            'card' => CardType::toResponseFormat($result['card']),
            'box' => BoxType::toResponseFormat($result['box'])
        ];
    }
}
