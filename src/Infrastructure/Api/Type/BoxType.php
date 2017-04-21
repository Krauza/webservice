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
                'id' => Type::string(),
                'name' => Type::string()
            ]
        ];

        parent::__construct($config);
    }
}
