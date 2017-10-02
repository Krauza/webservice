<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use Krauza\Infrastructure\Api\Type\BaseType;
use Krauza\Infrastructure\Api\Type\ResponseType;

final class CreateBoxType extends BaseType implements ResponseType
{
    protected function getConfig(): array
    {
        return [
            'fields' => [
                'box' => [
                    'type' => BoxType::getInstance(),
                    'description' => 'Created box'
                ]
            ]
        ];
    }

    public static function toResponseFormat(array $data): array
    {
        return [
            'box' => BoxType::toResponseFormat($data['box'])
        ];
    }
}
