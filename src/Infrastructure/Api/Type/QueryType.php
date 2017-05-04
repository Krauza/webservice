<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Infrastructure\Api\Action\FindNextCard;
use Krauza\Infrastructure\Api\TypeRegistry;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'args' => [
                        'id' => [
                            'type' => Type::string(),
                            'description' => 'The id of the box'
                        ]
                    ],
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        return BoxType::objectToArray($boxRepository->getById($args['id']));
                    }
                ],
                'card' => [
                    'type' => TypeRegistry::getCardType(),
                    'args' => [],
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        $cardRepository = new CardRepository($context['database_connection']);
                        $nextCardUseCase = new FindNextCardUseCase($boxRepository, $cardRepository);
                        $nextCard = new FindNextCard($nextCardUseCase, $boxRepository);
                        return $nextCard->action($args);
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
