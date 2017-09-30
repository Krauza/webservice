<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Core\Entity\Card;

class CardType extends ObjectType
{
    private static $instance;

    public function __construct()
    {
        $config = [
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The id of the card'
                ],
                'obverse' => [
                    'type' => Type::string(),
                    'description' => 'The obverse of the card'
                ],
                'reverse' => [
                    'type' => Type::string(),
                    'description' => 'The reverse of the card'
                ]
            ]
        ];

        parent::__construct($config);
    }

    public static function getInstance(): self
    {
        return self::$instance ?: (self::$instance = new self);
    }

    public static function toResponseFormat(Card $card): array
    {
        return [
            'id' => $card->getId(),
            'obverse' => $card->getObverse(),
            'reverse' => $card->getReverse()
        ];
    }
}
