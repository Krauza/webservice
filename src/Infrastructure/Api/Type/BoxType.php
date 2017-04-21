<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class BoxType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The id of the box'
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the box'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
