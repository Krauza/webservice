<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Core\Entity\Card;

class CardType extends ObjectType
{
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

    public static function objectToArray(Card $card): array
    {
        return [
            'id' => $card->getId(),
            'obverse' => $card->getObverse(),
            'reverse' => $card->getReverse()
        ];
    }
}
