<?php

namespace Krauza\Infrastructure\Api\Type\Mutation;

use Krauza\Infrastructure\Api\TypeRegistry;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\Api\Action\CreateBox as CreateBoxAction;

class CreateBox
{
    public static function config()
    {
        return [
            'type' => TypeRegistry::getCreateBoxType(),
            'args' => [
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Name of the box'
                ]
            ],
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                $boxUseCase = new CreateBoxUseCase($boxRepository, $context['id_policy']);
                $createBox = new CreateBoxAction($boxUseCase, $context['current_user']);
                return $createBox->action($args);
            }
        ];
    }
}
