<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;

class CreateBox
{
    public static function action($rootValue, $args, $context)
    {
        $response = ['box' => null, 'errors' => []];
        $boxRepository = new BoxRepository($context['database_connection']);
        $createBox = new CreateBoxUseCase($boxRepository, $context['id_policy']);

        try {
            $box = $createBox->add($args, $context['current_user']);
            $response['box'] = ['id' => $box->getId(), 'name' => $box->getName()];
        } catch (\Exception $e) {
            array_push($response['errors'], ['key' => 'error', 'message' => $e->getMessage()]);
        }

        return $response;
    }
}
