<?php

namespace Krauza\Infrastructure\Api\Type\Query;

use Krauza\Infrastructure\Api\Action\FindNextCard;
use Krauza\Infrastructure\Api\TypeRegistry;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\DataAccess\BoxSectionsRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;

class GetNextCard
{
    public static function config(): array
    {
        return [
            'type' => TypeRegistry::getCardType(),
            'args' => [
                'box_id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the parent box'
                ]
            ],
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                $boxSectionsRepository = new BoxSectionsRepository($context['database_connection']);
                $cardRepository = new CardRepository($context['database_connection']);
                $nextCardUseCase = new FindNextCardUseCase($boxSectionsRepository, $boxRepository, $cardRepository);

                $nextCard = new FindNextCard($nextCardUseCase, $boxRepository);
                return $nextCard->action($args);
            }
        ];
    }
}
