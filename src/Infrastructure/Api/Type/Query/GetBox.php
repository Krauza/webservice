<?php

namespace Krauza\Infrastructure\Api\Type\Query;

use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\Api\Type\Object\BoxType;

final class GetBox
{
    public static function config(): array
    {
        return [
            'type' => BoxType::getInstance(),
            'args' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the box'
                ]
            ],
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                return BoxType::toResponseFormat($boxRepository->getById($args['id']));
            }
        ];
    }
}
