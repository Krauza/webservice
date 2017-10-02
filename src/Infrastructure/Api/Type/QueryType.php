<?php

namespace Krauza\Infrastructure\Api\Type;

use Krauza\Infrastructure\Api\Type\Query\GetBox;
use Krauza\Infrastructure\Api\Type\Query\GetNextCard;
use Krauza\Infrastructure\Api\Type\Query\GetUserBoxes;

final class QueryType extends BaseType
{
    protected function getConfig(): array
    {
        return [
            'name' => 'Query',
            'fields' => [
                'getUserBoxes' => GetUserBoxes::config(),
                'getBox' => GetBox::config(),
                'getNextCard' => GetNextCard::config()
            ]
        ];
    }
}
