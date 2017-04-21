<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\TypeRegistry;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'hello' => [
                    'type' => Type::string(),
                    'resolve' => function () {
                        return 'world';
                    }
                ],
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'args' => [],
                    'resolve' => function ($root, $args) {
                        return ['id' => 'a', 'name' => 'b'];
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
