<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\User;
use Krauza\Core\Exception\FieldException;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Pimple\Container;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateBox
{
    /**
     * @var CreateBoxUseCase
     */
    private $boxUseCase;

    /**
     * @var User
     */
    private $currentUser;

    public function __construct(Container $container)
    {
        $boxRepository = new BoxRepository($container['database_connection']);
        $this->boxUseCase = new CreateBoxUseCase($boxRepository, $container['id_policy']);
        $this->currentUser = $container['current_user'];
    }

    public function action(array $data): array
    {
        $box = null;
        $errors = [];

        try {
            $box = $this->boxUseCase->add($data, $this->currentUser);
        } catch (FieldException $exception) {
            array_push($errors, $this->buildError('fieldException', $exception->getFieldName(), $exception->getMessage()));
        } catch (Exception $exception) {
            array_push($errors, $this->buildError('infrastructureException', '', 'Something went wrong, try again.'));
        }

        return ['box' => $box, 'errors' => $errors];
    }

    private function buildError(string $type, string $key, string $message): array
    {
        return ['errorType' => $type, 'key' => $key, 'message' => $message];
    }
}
