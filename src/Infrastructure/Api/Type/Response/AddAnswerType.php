<?php

namespace Krauza\Infrastructure\Api\Type\Response;

use GraphQL\Type\Definition\ObjectType;
use Krauza\Core\Entity\Box;
use Krauza\Infrastructure\Api\TypeRegistry;

class AddAnswerType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'box' => [
                    'type' => TypeRegistry::getBoxType(),
                    'description' => 'Parent box'
                ],
                'errors' => [
                    'type' => TypeRegistry::getErrorType(),
                    'description' => 'List of errors'
                ]
            ]
        ];

        parent::__construct($config);
    }

    public static function objectToArray(Box $box)
    {
        return ['id' => $box->getId(), 'name' => $box->getName()];
    }
}
