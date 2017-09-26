<?php

namespace Krauza\Infrastructure\Api\Type\Mutation;

use Krauza\Infrastructure\Api\TypeRegistry;
use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Infrastructure\Api\Action\CreateCard as CreateCardAction;
use Krauza\Infrastructure\DataAccess\BoxSectionsRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;

class CreateCard
{
    public static function config(): array
    {
        return [
            'type' => TypeRegistry::getCreateCardType(),
            'args' => [
                'box_id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the parent box'
                ],
                'obverse' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The obverse of the card'
                ],
                'reverse' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The reverse of the card'
                ]
            ],
            'resolve' => function ($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                $boxSectionsRepository = new BoxSectionsRepository($context['database_connection']);
                $cardRepository = new CardRepository($context['database_connection']);
                $cardUseCase = new CreateCardUseCase($cardRepository, $boxSectionsRepository, $context['id_policy']);
                $createCard = new CreateCardAction($cardUseCase, $boxRepository);
                return $createCard->action($args);
            }
        ];
    }
}
