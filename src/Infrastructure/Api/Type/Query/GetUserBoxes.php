<?php

namespace Krauza\Infrastructure\Api\Type\Query;

use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\Api\Type\Object\BoxType;

final class GetUserBoxes
{
    public static function config(): array
    {
        return [
            'type' => Type::listOf(BoxType::getInstance()),
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                $boxes = $boxRepository->getAllForUser($context['current_user']);

                return array_map(function ($box) {
                    return BoxType::toResponseFormat($box);
                }, $boxes);
            }
        ];
    }
}
