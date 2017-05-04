<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Exception\FieldException;

abstract class Action
{
    protected $result;
    protected $error;

    abstract public function action(array $data): array;

    protected function tryDoAction($callback): void
    {
        try {
            $this->result = $callback();
        } catch (FieldException $exception) {
            $this->buildError('fieldException', $exception->getFieldName(), $exception->getMessage());
        } catch (\Exception $exception) {
            $this->buildError('infrastructureException', '', 'Something went wrong, try again.');
        }
    }

    protected function buildError(string $type, string $key, string $message): void
    {
        $this->error = ['errorType' => $type, 'key' => $key, 'message' => $message];
    }
}
