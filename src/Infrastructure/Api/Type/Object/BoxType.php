<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use GraphQL\Type\Definition\Type;
use Krauza\Core\Entity\Box;
use Krauza\Infrastructure\Api\Type\BaseType;

final class BoxType extends BaseType
{
    protected function getConfig(): array
    {
        return [
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The id of the box'
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the box'
                ]
            ]
        ];
    }

    public static function toResponseFormat(Box $box)
    {
        return ['id' => $box->getId(), 'name' => $box->getName()];
    }
}
