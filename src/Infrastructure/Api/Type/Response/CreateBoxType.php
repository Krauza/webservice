<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use GraphQL\Type\Definition\ObjectType;
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
                    'type' => TypeRegistry::getErrorType(),
                    'description' => 'List of errors'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
