<?php

namespace Krauza\Infrastructure\Api\Type\Object;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Krauza\Core\Entity\Box;

class BoxType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The id of the box'
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the box'
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
