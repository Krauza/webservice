<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\TypeRegistry;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'createBox' => [
                    'type' => TypeRegistry::getBoxType(),
                    'args' => [
                        'name' => Type::string()
                    ],
                    'resolve' => function () {
                        // action
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
