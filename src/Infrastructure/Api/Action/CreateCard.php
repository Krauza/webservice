<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\Box;
use Krauza\Core\Exception\FieldException;
use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Infrastructure\Api\Type\BoxType;

class CreateCard
{
    private $cardUseCase;
    private $box;

    public function __construct(CreateCardUseCase $cardUseCase, Box $box)
    {
        $this->cardUseCase = $cardUseCase;
        $this->box = $box;
    }

    public function action(array $data): array
    {
        $box = null;
        $error = null;

        try {
            $this->cardUseCase->add($data, $this->box);
            $box = BoxType::objectToArray($this->box);
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
