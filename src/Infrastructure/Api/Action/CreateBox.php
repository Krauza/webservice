<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\User;
use Krauza\Core\Exception\FieldException;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\Api\Type\BoxType;

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

    public function __construct(CreateBoxUseCase $boxUseCase, User $currentUser)
    {
        $this->boxUseCase = $boxUseCase;
        $this->currentUser = $currentUser;
    }

    public function action(array $data): array
    {
        $box = null;
        $error = null;

        try {
            $newBox = $this->boxUseCase->add($data, $this->currentUser);
            $box = BoxType::objectToArray($newBox);
        } catch (FieldException $exception) {
            $error = $this->buildError('fieldException', $exception->getFieldName(), $exception->getMessage());
        } catch (\Exception $exception) {
            $error = $this->buildError('infrastructureException', '', 'Something went wrong, try again.');
        }

        return ['box' => $box, 'errors' => $error];
    }

    private function buildError(string $type, string $key, string $message): array
    {
        return ['errorType' => $type, 'key' => $key, 'message' => $message];
    }
}
