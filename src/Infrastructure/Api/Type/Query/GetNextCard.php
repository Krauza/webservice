<?php

namespace Krauza\Infrastructure\Api\Type\Query;

use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\Action\FindNextCard;
use Krauza\Infrastructure\Api\Type\Response\GetNextCardType;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\DataAccess\BoxSectionsRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;

final class GetNextCard
{
    public static function config(): array
    {
        return [
            'type' => GetNextCardType::getInstance(),
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
                return GetNextCardType::toResponseFormat($nextCard->action($args));
            }
        ];
    }
}
