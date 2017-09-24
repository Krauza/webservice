<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Infrastructure\Api\TypeRegistry;

class CreateCardType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'card' => [
                    'type' => TypeRegistry::getCardType(),
                    'description' => 'Created card'
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
