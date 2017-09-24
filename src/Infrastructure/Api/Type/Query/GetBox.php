<?php

namespace Krauza\Infrastructure\Api\Type\Query;

use Krauza\Infrastructure\Api\TypeRegistry;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\Api\Type\Object\BoxType;

class GetBox
{
    public static function config()
    {
        return [
            'type' => TypeRegistry::getBoxType(),
            'args' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the box'
                ]
            ],
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                return BoxType::objectToArray($boxRepository->getById($args['id']));
            }
        ];
    }
}
