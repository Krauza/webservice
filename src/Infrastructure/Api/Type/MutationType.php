<?php

namespace Krauza\Infrastructure\Api\Type;

use Krauza\Infrastructure\Api\Type\Mutation\AddAnswer;
use Krauza\Infrastructure\Api\Type\Mutation\CreateBox;
use Krauza\Infrastructure\Api\Type\Mutation\CreateCard;

class MutationType extends BaseType
{
    protected function getConfig(): array
    {
        return [
            'name' => 'Mutation',
            'fields' => [
                'createBox' => CreateBox::config(),
                'createCard' => CreateCard::config(),
                'addAnswer' => AddAnswer::config()
            ]
        ];
    }
}
