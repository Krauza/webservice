<?php

namespace Krauza\Infrastructure\Api\Type\Mutation;

use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\Type\Object\CreateBoxType;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\Api\Action\CreateBox as CreateBoxAction;

final class CreateBox
{
    public static function config(): array
    {
        return [
            'type' => CreateBoxType::getInstance(),
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
                return CreateBoxType::toResponseFormat($createBox->action($args));
            }
        ];
    }
}
