<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use Krauza\Infrastructure\Api\Type\BaseType;
use Krauza\Infrastructure\Api\Type\Object\BoxType;
use Krauza\Infrastructure\Api\Type\Object\CardType;
use Krauza\Infrastructure\Api\Type\ResponseType;

final class AddAnswerType extends BaseType implements ResponseType
{
    public function getConfig(): array
    {
        return [
            'fields' => [
                'card' => [
                    'type' => CardType::getInstance(),
                    'description' => 'Answered card'
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
