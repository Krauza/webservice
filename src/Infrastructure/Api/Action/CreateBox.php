<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;

class CreateBox
{
    public static function action($rootValue, $args, $context)
    {
        $createBox = new CreateBoxUseCase($context['database_connection'], $context['id_policy']);
        $createBox->add($args, $context['current_user']);
    }
}
