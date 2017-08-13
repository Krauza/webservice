<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Exception\FieldException;
use Krauza\Infrastructure\Api\Type\ErrorType;

abstract class Action
{
    protected $result;
    protected $error;

    abstract public function action(array $data): array;

    protected function tryDoAction(callable $actionFn): void
    {
        try {
            $this->result = $actionFn();
        } catch (FieldException $exception) {
            $this->error = ErrorType::buildArray('fieldException', $exception->getFieldName(), $exception->getMessage());
        } catch (\Exception $exception) {
            $this->error = ErrorType::buildArray('infrastructureException', '', 'Something went wrong, try again.');
        }
    }
}
