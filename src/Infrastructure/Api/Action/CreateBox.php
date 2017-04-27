<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;

class CreateBox
{
    public static function action($rootValue, $args, $context)
    {
        try {
            $boxRepository = new BoxRepository($context['database_connection']);
            $createBox = new CreateBoxUseCase($boxRepository, $context['id_policy']);
            $createBox->add($args, $context['current_user']);
        } catch (\Exception $e) {
            file_put_contents('php://stderr', $e);
        }

        return ['id' => 'test', 'name' => 'super test name'];
    }
}
