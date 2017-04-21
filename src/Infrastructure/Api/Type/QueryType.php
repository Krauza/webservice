<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Infrastructure\Api\TypeRegistry;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'args' => [],
                    'resolve' => function () {
                        return ['id' => 'test', 'name' => 'super test name'];
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
