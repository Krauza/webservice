<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use Krauza\Infrastructure\Api\Type\BaseType;
use Krauza\Infrastructure\Api\Type\ResponseType;

final class GetNextCardType extends BaseType implements ResponseType
{
    protected function getConfig(): array
    {
        return [
            'fields' => [
                'card' => [
                    'type' => CardType::getInstance(),
                    'description' => 'Next card'
                ],
                'box' => [
                    'type' => BoxType::getInstance(),
                    'description' => 'Parent box'
                ]
            ]
        ];
    }

    public static function toResponseFormat(array $result): array
    {
        return [
            'card' => CardType::toResponseFormat($result['card']),
            'box' => BoxType::toResponseFormat($result['box'])
        ];
    }
}
