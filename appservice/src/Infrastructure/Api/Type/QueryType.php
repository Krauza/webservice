<?php

namespace Krauza\Infrastructure\Api\Type;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use Krauza\Core\UseCase\AdjustFirstSection;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Core\UseCase\SetCurrentSection;
use Krauza\Infrastructure\Api\Action\FindNextCard;
use Krauza\Infrastructure\Api\TypeRegistry;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\DataAccess\BoxSectionsRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'boxes' => [
                    'type' => Type::listOf(TypeRegistry::getBoxType()),
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        return array_map(function ($box) {
                            return BoxType::objectToArray($box);
                        }, $boxRepository->getAllForUser($context['current_user']));
                    }
                ],
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => 'The id of the box'
                        ]
                    ],
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        return BoxType::objectToArray($boxRepository->getById($args['id']));
                    }
                ],
                'nextCard' => [
                    'type' => TypeRegistry::getCardType(),
                    'args' => [],
                    'resolve' => function ($rootValue, $args, $context) {
                        $boxRepository = new BoxRepository($context['database_connection']);
                        $boxSectionsRepository = new BoxSectionsRepository($context['database_connection']);
                        $cardRepository = new CardRepository($context['database_connection']);
                        $nextCardUseCase = new FindNextCardUseCase($boxSectionsRepository, $cardRepository);
                        $adjustFirstSection = new AdjustFirstSection($boxSectionsRepository);
                        $setCurrentSection = new SetCurrentSection($boxRepository, $boxSectionsRepository);
                        $nextCard = new FindNextCard($nextCardUseCase, $adjustFirstSection, $setCurrentSection, $boxRepository);
                        return $nextCard->action($args);
                    }
                ]
            ]
        ];

        parent::__construct($config);
    }
}
