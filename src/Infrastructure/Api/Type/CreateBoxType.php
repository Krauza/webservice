<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\TypeRegistry;

class CreateBoxType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'description' => 'Created box'
                ],
                'errors' => [
                    'type' => Type::listOf(TypeRegistry::getErrorType()),
                    'description' => 'List of errors'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
