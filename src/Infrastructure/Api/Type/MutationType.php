<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Infrastructure\Api\Type\Mutation\AddAnswer;
use Krauza\Infrastructure\Api\Type\Mutation\CreateBox;
use Krauza\Infrastructure\Api\Type\Mutation\CreateCard;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'createBox' => CreateBox::config(),
                'createCard' => CreateCard::config(),
                'addAnswer' => AddAnswer::config()
            ]
        ];

        parent::__construct($config);
    }
}
