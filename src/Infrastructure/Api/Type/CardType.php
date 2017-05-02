<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CardType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The id of the card'
                ],
                'obverse' => [
                    'type' => Type::string(),
                    'description' => 'The obverse of the card'
                ],
                'reverse' => [
                    'type' => Type::string(),
                    'description' => 'The reverse of the card'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
