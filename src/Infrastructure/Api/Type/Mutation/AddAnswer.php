<?php

namespace Krauza\Infrastructure\Api\Type\Mutation;

use GraphQL\Type\Definition\Type;
use Krauza\Infrastructure\Api\Type\Object\AddAnswerType;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Infrastructure\Api\Action\AddAnswer as AddAnswerAction;
use Krauza\Infrastructure\DataAccess\BoxSectionsRepository;
use Krauza\Infrastructure\DataAccess\CardRepository;
use Krauza\Core\UseCase\AddAnswer as AddAnswerUseCase;

final class AddAnswer
{
    public static function config(): array
    {
        return [
            'type' => AddAnswerType::getInstance(),
            'description' => 'Add answer for the card',
            'args' => [
                'answer' => [
                    'type' => Type::nonNull(Type::boolean()),
                    'description' => 'The answer for the card. User knew the answer or not.'
                ],
                'box_id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the box'
                ],
                'card_id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the card'
                ]
            ],
            'resolve' => function($rootValue, $args, $context) {
                $boxRepository = new BoxRepository($context['database_connection']);
                $cardRepository = new CardRepository($context['database_connection']);
                $boxSectionsRepository = new BoxSectionsRepository($context['database_connection']);
                $addAnswerUseCase = new AddAnswerUseCase($boxSectionsRepository);

                $addAnswer = new AddAnswerAction($addAnswerUseCase, $cardRepository, $boxRepository);
                return AddAnswerType::toResponseFormat($addAnswer->action($args));
            }
        ];
    }
}
