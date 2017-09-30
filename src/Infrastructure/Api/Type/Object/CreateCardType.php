<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use Krauza\Infrastructure\Api\Type\BaseType;
use Krauza\Infrastructure\Api\Type\Object\BoxType;
use Krauza\Infrastructure\Api\Type\Object\CardType;
use Krauza\Infrastructure\Api\Type\ResponseType;

final class CreateCardType extends BaseType implements ResponseType
{
    protected function getConfig(): array
    {
        return [
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
    }

    public static function toResponseFormat(array $result): array
    {
        return [
            'card' => CardType::toResponseFormat($result['card']),
            'box' => BoxType::toResponseFormat($result['box'])
        ];
    }
}
