<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ErrorType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'key' => [
                    'type' => Type::string(),
                    'description' => 'The key of the error'
                ],
                'message' => [
                    'type' => Type::string(),
                    'description' => 'The message of the error'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
