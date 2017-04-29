<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\Action\CreateBox;
use Krauza\Infrastructure\Api\TypeRegistry;

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
                        $createBox = new CreateBox($context);
                        return $createBox->action($args);
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
