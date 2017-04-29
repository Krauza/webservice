<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Exception\FieldException;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateBox
{
    public static function action(array $data, $context): array
    {
        $box = null;
        $errors = [];
        $boxRepository = new BoxRepository($context['database_connection']);
        $createBox = new CreateBoxUseCase($boxRepository, $context['id_policy']);

        try {
            $box = $createBox->add($data, $context['current_user']);
        } catch (FieldException $exception) {
            array_push($errors, static::buildError('fieldException', $exception->getFieldName(), $exception->getMessage()));
        } catch (Exception $exception) {
            array_push($errors, static::buildError('infrastructureException', '', 'Something went wrong, try again.'));
        }

        return static::buildResponse($box, $errors);
    }

    private static function buildResponse($box, $errors): array
    {
        return ['box' => $box, 'errors' => $errors];
    }

    private static function buildError(string $type, string $key, string $message): array
    {
        return ['errorType' => $type, 'key' => $key, 'message' => $message];
    }
}
