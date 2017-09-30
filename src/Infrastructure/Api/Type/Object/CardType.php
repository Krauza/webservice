<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use GraphQL\Type\Definition\Type;
use Krauza\Core\Entity\Card;
use Krauza\Infrastructure\Api\Type\BaseType;

final class CardType extends BaseType
{
    protected function getConfig(): array
    {
        return [
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
