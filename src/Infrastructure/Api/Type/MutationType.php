<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\Action\CreateBox;
use Krauza\Infrastructure\Api\TypeRegistry;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'createBox' => [
                    'type' => TypeRegistry::getCreateBoxType(),
                    'args' => [
                        'name' => [
                            'type' => Type::string(),
                            'description' => 'Name of the box'
                        ]
                    ],
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        $boxUseCase = new CreateBoxUseCase($boxRepository, $context['id_policy']);
                        $createBox = new CreateBox($boxUseCase, $context['current_user']);
                        return $createBox->action($args);
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
