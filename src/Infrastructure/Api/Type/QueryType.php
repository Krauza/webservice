<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Infrastructure\Api\Type\Query\GetBox;
use Krauza\Infrastructure\Api\Type\Query\GetNextCard;
use Krauza\Infrastructure\Api\Type\Query\GetUserBoxes;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'getUserBoxes' => GetUserBoxes::config(),
                'getBox' => GetBox::config(),
                'getNextCard' => GetNextCard::config()
            ]
        ];

        parent::__construct($config);
    }
}
